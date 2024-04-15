<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
// header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

include "config.php";

$data       = file_get_contents('php://input');
$json_data  = json_decode($data , true);

$RequestMethod = $_SERVER["REQUEST_METHOD"];

if($RequestMethod == "POST"){
    $email		= strtolower(addslashes((trim($json_data['email']))));
    $password	= addslashes((trim($json_data['password'])));
    $platform  	= addslashes((trim($json_data['platform'])));
    $type   	= addslashes((trim($json_data['type'])));

    $CheckUserQuery        = "SELECT * FROM pre_users WHERE email = '$email'";
    $CheckUserQueryResults = mysqli_query($conn,$CheckUserQuery);

    if($CheckUserQueryResults){
        if (mysqli_num_rows($CheckUserQueryResults) > 0) 
        {
            while($record = mysqli_fetch_assoc($CheckUserQueryResults)) 
            {
                $verify = password_verify($password, $record["password"]); 
                $AccountType = "";

                if($record["user_belongs_group"] == "1"){
                    $AccountType = "Admin";
                }else if($record["user_belongs_group"] == "2"){
                    $AccountType = "Student";
                }else if($record["user_belongs_group"] == "3"){
                    $AccountType = "Tutor";
                }else if($record["user_belongs_group"] == "4"){
                    $AccountType = "Institute";
                }


                if ($verify) { 

                  
                    if($platform == "web"){
                        $_SESSION["user_logged_in"] =  true;
                        $_SESSION["user_id"]        =  $record["id"];
                        $_SESSION["user_name"]      =  $record["username"];
                        $_SESSION["user_email"]     =  $record["email"];
                        $_SESSION["user_profile_image"]   = PROFILE . $record["photo"];

                        $Data =[
                            'status' => 200,
                            'message' => 'Success'
                        ];
                    
                        header("HTTP/1.0 200 Success");
                        echo json_encode($Data);
                    }else{
                     


                        $Data =[
                            'status' => 200,
                            'message' => 'Login Success',
                            'user_logged_in' => 'true',
                            'user_id' => $record["id"],
                            'user_name' => $record["username"],
                            'user_email' => $record["email"],
                            'user_type' => $AccountType,
                            'user_profile_image' => PROFILE . $record["photo"]
                        ];
                    
                        header("HTTP/1.0 200 Success");
                        echo json_encode($Data);

                    }
                    
                } else { 
              
                    $Data =[
                        'status' => 404,
                        'message' => 'Incorrect Username or Password'
                    ];
                
                    header("HTTP/1.0 200 Incorrect Username or Password");
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
