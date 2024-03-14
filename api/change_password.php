<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
// header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

include "config.php";


$RequestMethod = $_SERVER["REQUEST_METHOD"];

if($RequestMethod == "POST"){
    $user_id		    = addslashes(ucfirst(trim($_REQUEST['id'])));
    $password		    = addslashes(ucfirst(trim($_REQUEST['password'])));
    $new_password		= addslashes(ucfirst(trim($_REQUEST['new_password'])));

    $CheckUserQuery        = "SELECT * FROM pre_users WHERE id = '$user_id'";
    $CheckUserQueryResults = mysqli_query($conn,$CheckUserQuery);

    if($CheckUserQueryResults){
        if (mysqli_num_rows($CheckUserQueryResults) > 0) 
        {
            while($record = mysqli_fetch_assoc($CheckUserQueryResults)) 
            {
                $verify = password_verify($password, $record["password"]); 
              
                if ($verify) { 

                    $InsertArray                  = array();
                    $InsertArray["password"]      = password_hash($new_password,PASSWORD_DEFAULT);

                    $UpdatProfile = "UPDATE pre_users SET ";
                    foreach($InsertArray as $k => $v)
                    {
                        $UpdatProfile .= $k."='". $v."', ";
                    }
                    $UpdatProfile = rtrim($UpdatProfile, ", ");
                    $UpdatProfile .= " where id = $user_id";
                    
                    $Data =[
                        'status' => 200,
                        'message' => 'Password Updated'
                    ];
                
                    header("HTTP/1.0 200 Password Updated");
                    echo json_encode($Data);

                } else { 
              
                    $Data =[
                        'status' => 404,
                        'message' => 'Incorrect Password'
                    ];
                
                    header("HTTP/1.0 200 Incorrect Password");
                    echo json_encode($Data);
                } 
            }
        }else{
            $Data =[
                'status' => 404,
                'message' => 'No User Found'
            ];
        
            header("HTTP/1.0 200 No User Found");
            echo json_encode($Data);
        }

    }else{
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
