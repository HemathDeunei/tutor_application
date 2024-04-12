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
        $id		    = addslashes(trim($_REQUEST['id']));
        $user_id	= addslashes(trim($_REQUEST['user_id']));
        $type		= addslashes(trim($_REQUEST['type']));

        $status       = getBookingStatus($conn,$id);
        $StatusArray  = array();

        if($type == "student")
        {
            if($status == "pending"){
                array_push($StatusArray,"cancelled_before_course_started");
            }else if($status == "approved"){
                array_push($StatusArray,"cancelled_before_course_started");
            }else if($status == "session_initiated"){
                array_push($StatusArray,"running");
                array_push($StatusArray,"cancelled_before_course_started");
            }else if($status == "running"){
                array_push($StatusArray,"running");
                array_push($StatusArray,"cancelled_when_course_running");
            }else if($status == "completed"){
                array_push($StatusArray,"closed");
            }

        }else{
            if($status == "pending"){
                array_push($StatusArray,"approved");
            }else if($status == "approved"){
                array_push($StatusArray,"session_initiated");
                array_push($StatusArray,"cancelled_before_course_started");
            }else if($status == "session_initiated"){
                array_push($StatusArray,"cancelled_before_course_started");
            }else if($status == "running"){
                array_push($StatusArray,"completed");
                array_push($StatusArray,"cancelled_when_course_running");
            }
        }

        $Data =[
            'status' => 200,
            'current_status' => $status,
            'status_options' => $StatusArray,
        ];
    
        header("HTTP/1.0 200 success");
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