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

if($RequestMethod == "GET"){
    try {
        $student_id 		= addslashes((trim($_REQUEST['student'])));
        $course		        = addslashes((trim($_REQUEST['course'])));
        $tutor		        = addslashes((trim($_REQUEST['tutor'])));


        $CourseDetails  = getTutorCourseDetails($conn, $tutor, $course);
        $StudentDetails = getStudentDetails($conn, $student_id);
        $BookingDetails = getBookingDetails($conn, $tutor, $course);

        $StudentCredits = (int) $StudentDetails["net_credits"];
        $CourseCredits  = (int) $CourseDetails["fee"];

        if($StudentCredits < $CourseCredits)
        {
            $Data =[
                'status' => 400,
                'message' => 'Not enought credits',
            ];
        
            header("HTTP/1.0 200 Success");
            echo json_encode($Data);
            exit;
        }

        $Data =[
            'status' => 200,
            'message' => 'Success',
            'data' => $StudentDetails["username"],
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