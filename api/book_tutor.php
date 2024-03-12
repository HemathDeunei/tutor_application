<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, 
Access-Control-Request-Method, Access-Control-Allow-Origin");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "config.php";
include "functions.php";


$RequestMethod = $_SERVER["REQUEST_METHOD"];

if($RequestMethod == "POST"){
    try {
        $student_id 		= addslashes((trim($_REQUEST['student'])));
        $course		        = addslashes((trim($_REQUEST['course'])));
        $tutor		        = addslashes((trim($_REQUEST['tutor'])));
        $date		        = addslashes((trim($_REQUEST['date'])));
        $message		    = addslashes((trim($_REQUEST['message'])));
        $preferred_location	= addslashes((trim($_REQUEST['location'])));
        $slot             	= addslashes((trim($_REQUEST['slot'])));


        $CourseDetails  = getTutorCourseDetails($conn, $tutor, $course);
        $StudentDetails = getStudentDetails($conn, $student_id);
        $BookingDetails = getBookingDetails($conn, $student_id, $tutor, $course);
        $TutorDetails   = getTutorDetails($conn, $tutor);

        $StudentCredits = (int) $StudentDetails["net_credits"];
        $CourseCredits  = (int) $CourseDetails["fee"];

        if($StudentCredits < $CourseCredits)
        {
            $Data =[
                'status' => 200,
                'message' => 'Not enought credits',
            ];
        
            header("HTTP/1.0 300 Not enought credits");
            echo json_encode($Data);
            exit;
        }

        if($BookingDetails != false){

            if($BookingDetails["status"] == "pending" || $BookingDetails["status"] == "approved" || $BookingDetails["status"] == "running" || $BookingDetails["status"] == "session_initiated"){
                $Data =[
                    'status' => 200,
                    'message' => 'You already booked this tutor and your course not yet completed.',
                ];
            
                header("HTTP/1.0 300 Already Booked");
                echo json_encode($Data);
                exit;
            }
           
        }

		$content 				= $CourseDetails["content"];
        $duration_value 		= $CourseDetails["duration_value"];
		$duration_type 			= $CourseDetails["duration_type"];
		$time_slot   			= $slot;
        $start_date  			= date('Y-m-d', strtotime($date));
        $days_off 				= $CourseDetails["days_off"];
		$per_credit_value 		= $CourseDetails["per_credit_value"];
        $fee                    = $CourseDetails["fee"];
        $admin_commission   	= "10";
		$admin_commission_val   = round($fee * ($admin_commission / 100));

        if($duration_type == "hours") {

			$formatted  = str_replace(':', '.', $time_slot);
			$time 	    = explode('-', str_replace(' ', '', $formatted));

			$start_time = number_format($time[0],2);
			$end_time   = number_format($time[1],2);

			$total_time = $end_time - $start_time;

			if($total_time >= 1) {

				$days = round($duration_value / $total_time);

			} else {

				$total_time = (int)(explode('.', number_format($total_time,2))[1]);
				$days = round($duration_value / ($total_time/60));
			}

			$end_date = date("Y-m-d", strtotime($start_date.'+'.$days.' days'));

		} else {
			$end_date = date("Y-m-d", strtotime($start_date.'+'.$duration_value.' '.$duration_type));
		}

        $end_date           = date("Y-m-d", strtotime($end_date.'-1 days'));
        $created_at   		= date('Y-m-d H:i:s');
		$updated_at   		= $created_at;
		$updated_by   		= $student_id;

        $BookingArray                              = array();
        $BookingArray["student_id"]                = $student_id;
        $BookingArray["tutor_id"]                  = $tutor;
        $BookingArray["course_id"]                 = $course;
        $BookingArray["content"]                   = $content;
        $BookingArray["duration_value"]            = $duration_value;
        $BookingArray["duration_type"]             = $duration_type;
        $BookingArray["fee"]                       = $fee;
        $BookingArray["per_credit_value"]          = $per_credit_value;
        $BookingArray["start_date"]                = $start_date;
        $BookingArray["end_date"]                  = $end_date;
        $BookingArray["time_slot"]                 = $time_slot;
        $BookingArray["days_off"]                  = $days_off;
        $BookingArray["preferred_location"]        = $preferred_location;
        $BookingArray["message"]                   = $message;
        $BookingArray["admin_commission"]          = $admin_commission;
        $BookingArray["admin_commission_val"]      = $admin_commission_val;
        $BookingArray["created_at"]                = $created_at;
        $BookingArray["updated_at"]                = $updated_at;
        $BookingArray["updated_by"]                = $updated_by;

        $columns = implode(", ",array_keys($BookingArray));
        $escaped_values = array_map(array($conn, 'real_escape_string'), array_values($BookingArray));
        $values  = implode("', '", $escaped_values);
        $StoreQuery = "INSERT INTO pre_bookings ($columns) VALUES ('$values')";
        $ExecuteStoreQuery = mysqli_query($conn,$StoreQuery) or die ("Error in query: $StoreQuery. ".mysqli_error($conn));

        $ref = mysqli_insert_id($conn);

        $log_data = array(
            'user_id' => $student_id,
            'credits' => $fee,
            'per_credit_value' => $per_credit_value,
            'action'  => 'debited',
            'purpose' => 'Slot booked with the Tutor "'.$TutorDetails["slug"].'" and Booking Id is '.$ref,
            'date_of_action	' => date('Y-m-d H:i:s'),
            'reference_table' => 'bookings',
            'reference_id' => $ref,
        );

        $columns = implode(", ",array_keys($log_data));
        $escaped_values = array_map(array($conn, 'real_escape_string'), array_values($log_data));
        $values  = implode("', '", $escaped_values);
        $StoreQuery = "INSERT INTO pre_user_credit_transactions ($columns) VALUES ('$values')";
        $ExecuteStoreQuery = mysqli_query($conn,$StoreQuery) or die ("Error in query: $StoreQuery. ".mysqli_error($conn));

        $TotalCredits = (int) $StudentDetails["net_credits"];
        $SpentCredits = (int) $fee;
        $NetCredits   = $TotalCredits - $SpentCredits;

        $UpdateArray                              = array();
        $UpdateArray["net_credits"]               = $NetCredits;
        $UpdateArray["last_updated"]              = date('Y-m-d H:i:s');

        $UpdatProfile = "UPDATE pre_users SET ";
        foreach($UpdateArray as $k => $v)
        {
            $UpdatProfile .= $k."='". $v."', ";
        }
        $UpdatProfile = rtrim($UpdatProfile, ", ");
        $UpdatProfile .= " where id = $student_id";

        $ExecuteQuery = mysqli_query($conn,$UpdatProfile) or die ("Error in query: $UpdatProfile. ".mysqli_error($conn));

        

        $Data =[
            'status' => 200,
            'message' => 'Success',
        ];
    
        header("HTTP/1.0 200 Success");
        echo json_encode($Data);


     

    } catch (Exception $ex) {
        $Data =[
            'status' => 500,
            'message' => 'Internal Server Error'
        ];
    
        header("HTTP/1.0 500 Internal Server Error");
        echo json_encode($Data);
    }
}else{
    $Data =[
        'status' => 405,
        'message' => $RequestMethod . ' Method Not Allowed'
    ];

    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($Data);
}

?>