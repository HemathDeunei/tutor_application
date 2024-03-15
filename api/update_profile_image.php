<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
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
        $uploadDirectory    = PROFILE_UPLOAD_PATH . '/';
        $uploadURL          = PROFILE;
        $image_file_path    = "";

        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        $file_ext  =    pathinfo($_FILES["profile_image"]['name'], PATHINFO_EXTENSION);
        $file_name = $_FILES["profile_image"]["name"];
        $file_tmp  = $_FILES["profile_image"]["tmp_name"];
        $ext       = pathinfo($file_name, PATHINFO_EXTENSION);

        if (in_array($ext, ['jpeg', 'jpg', 'png', 'gif','PNG', 'jfif'])) {
            $newFileName = uniqid("profile_") . "." . $file_ext;
            $uploadPath = $uploadDirectory . $newFileName;

            if (move_uploaded_file($file_tmp, $uploadPath)) {
                // $image_file_path= $uploadURL . $newFileName;
                $image_file_path = $newFileName;

            }
        }

    

        $UserArray                            = array();
        $UserArray["photo"]                   = $image_file_path;
       

        $UpdatProfile = "UPDATE pre_users SET ";
        foreach($UserArray as $k => $v)
        {
            $UpdatProfile .= $k."='". $v."', ";
        }
        $UpdatProfile = rtrim($UpdatProfile, ", ");
        $UpdatProfile .= " where id = $user_id";


        $Data =[
            'status' => 200,
            'message' => 'Profile Image Updated',
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