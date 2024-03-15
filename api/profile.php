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
        $user_id		    = addslashes(trim($_REQUEST['user_id']));
        
        $UserDetails    = getUserDetails($conn, $user_id);

        $UserArray                            = array();
        $UserArray["user_id"]                 = $UserDetails["id"];
        $UserArray["first_name"]              = $UserDetails["first_name"];
        $UserArray["last_name"]               = $UserDetails["last_name"];
        $UserArray["email"]                   = $UserDetails["email"];
        $UserArray["dob"]                     = $UserDetails["dob"];
        $UserArray["gender"]                  = $UserDetails["gender"];
        $UserArray["website"]                 = $UserDetails["website"];
        $UserArray["image"]                   = PROFILE . $UserDetails["photo"];
        $UserArray["profile"]                 = $UserDetails["profile"];
        $UserArray["qualification"]           = $UserDetails["qualification"];
        $UserArray["profile_page_title"]      = $UserDetails["profile_page_title"];
        $UserArray["username"]                = $UserDetails["username"];
        $UserArray["total_credits"]           = $UserDetails["net_credits"];
        $UserArray["total_bookings"]          = getTotalBookings($conn, $user_id);
        $UserArray["total_pending_bookings"]  = getPendingBookings($conn, $user_id);


        $Data =[
            'status' => 200,
            'message' => 'Success',
            'data' => $UserArray,
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