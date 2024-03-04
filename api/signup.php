<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, 
Access-Control-Request-Method, Access-Control-Allow-Origin");

include "config.php";

$RequestMethod = $_SERVER["REQUEST_METHOD"];

if($RequestMethod == "POST"){
    try {
        $type		= strtolower(addslashes((trim($_REQUEST['type']))));
        $first_name	= addslashes((trim($_REQUEST['first_name'])));
        $last_name	= addslashes((trim($_REQUEST['last_name'])));
        $email	    = addslashes((trim($_REQUEST['email'])));
        $password	= addslashes((trim($_REQUEST['password'])));


        $InsertArray                              = array();
        $InsertArray["ip_address"]                = $_SERVER['SERVER_ADDR'];
        $InsertArray["username"]                  = ucfirst($first_name)." ".ucfirst($last_name);
        $InsertArray["slug"]                      = strtolower($first_name)."-".strtolower($last_name);
        $InsertArray["password"]                  = password_hash($password,PASSWORD_DEFAULT);
        $InsertArray["email"]                     = $email;
        $InsertArray["active"]                    = 1;
        $InsertArray["first_name"]                = ucfirst($first_name);
        $InsertArray["last_name"]                 = ucfirst($last_name);
        $InsertArray["user_belongs_group"]        = $type == "student" ? "2" : "3";
        $InsertArray["photo"]                     = "default-tutor-male.jpg";
        
        $columns = implode(", ",array_keys($InsertArray));
        $escaped_values = array_map(array($conn, 'real_escape_string'), array_values($InsertArray));
        $values  = implode("', '", $escaped_values);
        $AddNewUserQuery = "INSERT INTO pre_users ($columns) VALUES ('$values')";
        $ExecuteAddNewUserQuery = mysqli_query($conn,$AddNewUserQuery) or die ("Error in query: $AddNewUserQuery. ".mysqli_error($conn));

        $last_id = mysqli_insert_id($conn);

        $GroupArray                              = array();
        $GroupArray["user_id"]                   = mysqli_insert_id($conn);
        $GroupArray["group_id"]                  = $type == "student" ? "2" : "3";

        $columns = implode(", ",array_keys($GroupArray));
        $escaped_values = array_map(array($conn, 'real_escape_string'), array_values($GroupArray));
        $values  = implode("', '", $escaped_values);
        $AddNewUserQuery = "INSERT INTO pre_users_groups ($columns) VALUES ('$values')";
        $ExecuteAddNewUserQuery = mysqli_query($conn,$AddNewUserQuery) or die ("Error in query: $AddNewUserQuery. ".mysqli_error($conn));

        $Data =[
            'status' => 200,
            'message' => 'Registration Success'
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