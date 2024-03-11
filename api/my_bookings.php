<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, 
Access-Control-Request-Method, Access-Control-Allow-Origin");

include "config.php";
include "functions.php";

$RequestMethod = $_SERVER["REQUEST_METHOD"];

if($RequestMethod == "POST"){
    try {
        $student		        = addslashes(ucfirst(trim($_REQUEST['student'])));

        $Query      = "SELECT * FROM pre_bookings WHERE student_id = '".$student."' ORDER BY booking_id DESC";

        $Results    = mysqli_query($conn,$Query);
        $ListArray  = array();

        if($Results){
            if (mysqli_num_rows($Results) > 0) 
            {
                while($record = mysqli_fetch_assoc($Results)) 
                {
                    $data = array();
                    $data["booking_id "]             = $record["booking_id "];
                    $data["student_id"]              = $record["student_id"];
                    $data["tutor_id"]                = $record["tutor_id"];
                    $data["course_id"]               = $record["course_id"];

                    $TutorDetails   = getTutorDetails($conn,$record["tutor_id"]);
                    $CourseDetails  = getCourse($conn, $record["course_id"]);

                    $data["tutor_name"]              = $TutorDetails["username"];
                    $data["course_name"]             = $CourseDetails["name"];

                    $data["duration"]                = $record["duration_value"]." ".$record["duration_type"];
                    $data["fee"]                     = $record["fee"];
                    $data["commence_date"]           = $record["start_date"];
                    $data["time_slot"]               = $record["time_slot"];
                    $data["location"]                = $record["preferred_location"];
                    $data["prev_status"]             = $record["prev_status"];
                    $data["status"]                  = $record["status"];

                    array_push($ListArray,$data);

                }

                $Data =[
                    'status' => 200,
                    'message' => 'Success',
                    'data' => $ListArray,
                ];
            
                header("HTTP/1.0 200 Success");
                echo json_encode($Data);
            }else{
                $Data =[
                    'status' => 404,
                    'message' => 'No Details Found'
                ];
            
                header("HTTP/1.0 404 No Details Found");
                echo json_encode($Data);
            }

        }else{
            $Data =[
                'status' => 500,
                'message' => 'Internal Server Error'
            ];
        
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode($Data);
        }

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