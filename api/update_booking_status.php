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
        $status		= addslashes(trim($_REQUEST['status']));
        $desc		= addslashes(trim($_REQUEST['description']));

        $previous_status       = getBookingStatus($conn,$id);

        $UserArray                            = array();
        $UserArray["prev_status"]             = $previous_status;
        $UserArray["status"]                  = $status;
        $UserArray["status_desc"]             = $desc;
        $UserArray["updated_at"]              = date('Y-m-d H:i:s');
        $UserArray["updated_by"]              = $user_id;

        $UpdatProfile = "UPDATE pre_bookings SET ";
        foreach($UserArray as $k => $v)
        {
            $UpdatProfile .= $k."='". $v."', ";
        }
        $UpdatProfile = rtrim($UpdatProfile, ", ");
        $UpdatProfile .= " where booking_id = $id";

        $ExecuteQuery = mysqli_query($conn,$UpdatProfile) or die ("Error in query: $UpdatProfile. ".mysqli_error($conn));

        $Data =[
            'status' => 200,
            'message' => 'Status Updated'
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