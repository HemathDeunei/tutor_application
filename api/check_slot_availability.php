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

$RequestMethod = $_SERVER["REQUEST_METHOD"];

if($RequestMethod == "GET"){
    try {
        $date	= addslashes((trim($_REQUEST['date'])));
        $course	    = addslashes((trim($_REQUEST['course'])));
        $tutor	= addslashes((trim($_REQUEST['tutor'])));


        $CourseDetails  = getTutorCourseDetails($conn, $tutor, $course);

        $time_slot   			= $CourseDetails["time_slots"];
        $SlotArray              = explode(',',$time_slot);

        $Query      = "SELECT * FROM `pre_bookings` WHERE start_date >= '".$date."' AND end_date <= '".$date."' AND tutor_id = '".$tutor."' AND course_id = '".$course."'";
        $Results    = mysqli_query($conn,$Query);

        $AvailableSlots = array();
        if (mysqli_num_rows($Results) > 0) 
        {
            while($record = mysqli_fetch_assoc($Results)) 
            {
                
                if(!in_array($record["time_slot"], $SlotArray, TRUE))
                {
                    array_push($AvailableSlots,$record["time_slot"]);
                }
            }

        }

        $Data =[
            'status' => 200,
            'message' => 'Slots received',
            'slots' => $AvailableSlots
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