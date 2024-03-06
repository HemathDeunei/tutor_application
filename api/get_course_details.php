<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, 
Access-Control-Request-Method, Access-Control-Allow-Origin");

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include "config.php";
include "functions.php";


$RequestMethod = $_SERVER["REQUEST_METHOD"];

if($RequestMethod == "POST"){
    try {
        $course		= addslashes((trim($_REQUEST['course'])));
        $tutor		= addslashes((trim($_REQUEST['tutor'])));

        $data = getSelectedTutorCourses($conn, $tutor, $course);

        $Data =[
            'status' => 200,
            'message' => 'Success',
            'tutor_id' => $data["tutor_id"],
            'course_id' => $data["course_id"],
            'time_slots' => $data["time_slots"],
            'mode' => $data["mode"],
            'credits' => $data["credits"],
            'duration' => $data["duration"],
            'days_off' => $data["days_off"],
            'name' => $data["name"],
            'image' => $data["image"],
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