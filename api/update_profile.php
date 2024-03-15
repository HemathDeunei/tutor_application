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

if($RequestMethod == "POST")
{
    try {
        $user_id		    = addslashes(trim($_REQUEST['user_id']));
        $first_name		    = addslashes(ucfirst(trim($_REQUEST['first_name'])));
        $last_name		    = addslashes(ucfirst(trim($_REQUEST['last_name'])));
        $email		        = addslashes(trim($_REQUEST['email']));
        $dob		        = addslashes(trim($_REQUEST['dob']));
        $gender		        = addslashes(trim($_REQUEST['gender']));
        $website		    = addslashes(trim($_REQUEST['website']));
        $profile		    = addslashes(trim($_REQUEST['profile']));
        $qualification	    = addslashes(trim($_REQUEST['qualification']));
        $profile_page_title = addslashes(trim($_REQUEST['profile_page_title']));


        $UserArray                            = array();
        $UserArray["first_name"]              = $first_name;
        $UserArray["last_name"]               = $last_name;
        $UserArray["email"]                   = $email;
        $UserArray["dob"]                     = $dob;
        $UserArray["gender"]                  = $gender;
        $UserArray["website"]                 = $website;
        $UserArray["profile"]                 = $profile;
        $UserArray["qualification"]           = $qualification;
        $UserArray["profile_page_title"]      = $profile_page_title;

        $UpdatProfile = "UPDATE pre_users SET ";
        foreach($UserArray as $k => $v)
        {
            $UpdatProfile .= $k."='". $v."', ";
        }
        $UpdatProfile = rtrim($UpdatProfile, ", ");
        $UpdatProfile .= " where id = $user_id";

        $ExecuteQuery = mysqli_query($conn,$UpdatProfile) or die ("Error in query: $UpdatProfile. ".mysqli_error($conn));


        $Data =[
            'status' => 200,
            'message' => 'Profile Updated',
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