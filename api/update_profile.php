<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, 
Access-Control-Request-Method, Access-Control-Allow-Origin");

include "config.php";
include "functions.php";

$RequestMethod = $_SERVER["REQUEST_METHOD"];

if($RequestMethod == "POST")
{
    try {
        $user_id		    = addslashes(ucfirst(trim($_REQUEST['user_id'])));
        $first_name		    = addslashes(ucfirst(trim($_REQUEST['first_name'])));
        $last_name		    = addslashes(ucfirst(trim($_REQUEST['last_name'])));
        $email		        = addslashes(ucfirst(trim($_REQUEST['email'])));
        $dob		        = addslashes(ucfirst(trim($_REQUEST['dob'])));
        $gender		        = addslashes(ucfirst(trim($_REQUEST['gender'])));
        $website		    = addslashes(ucfirst(trim($_REQUEST['website'])));
        $profile		    = addslashes(ucfirst(trim($_REQUEST['profile'])));
        $qualification	    = addslashes(ucfirst(trim($_REQUEST['qualification'])));
        $profile_page_title = addslashes(ucfirst(trim($_REQUEST['profile_page_title'])));


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