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
        $course		= addslashes((trim($_REQUEST['course'])));

        $Query      = "SELECT tc.*, pu.username, pu.photo, pu.teaching_experience, pu.duration_of_experience, pu.qualification FROM pre_tutor_courses AS tc INNER JOIN pre_users AS pu ON tc.tutor_id = pu.id WHERE tc.course_id = '".$course."'";

        $Results    = mysqli_query($conn,$Query);
        $ListArray  = array();

        if($Results){
            if (mysqli_num_rows($Results) > 0) 
            {
                while($record = mysqli_fetch_assoc($Results)) 
                {
                    $data = array();
                    $data["tutor_id"]       = $record["tutor_id"];
                    $data["course_id"]      = $record["course_id"];
                    $data["username"]       = $record["username"];

                    $Courses = getTutorCourses($conn, $record["tutor_id"]);

                    $data["teaches"]       = implode(",",$Courses);

                    $image = "";

                    if(empty($record["photo"])){
                        $image = PROFILE . "default-tutor-male.jpg";
                    }else{
                        $image = PROFILE . $record["photo"];

                    }

                    $data["photo"]          = $image;
                    $data["experience"]     = $record["teaching_experience"]." ".$record["duration_of_experience"];

                    $qualification = "";

                    if(empty($record["qualification"])){
                        $qualification = "NA";
                    }else{
                        $qualification = $record["qualification"];

                    }
                    $data["qualification"]  = $qualification;
                    
                    array_push($ListArray,$data);

                }

                $Data =[
                    'status' => 200,
                    'message' => 'Success',
                    'data' => $ListArray,
                ];
            
                header("HTTP/1.0 200 Success");
                echo json_encode($Data);
            }else{
                $Data =[
                    'status' => 200,
                    'message' => 'No Course Found'
                ];
            
                header("HTTP/1.0 200 No Course Found");
                echo json_encode($Data);
            }

        }else{
            $Data =[
                'status' => 200,
                'message' => 'No Course Found'
            ];
        
            header("HTTP/1.0 200 No Course Found");
            echo json_encode($Data);
        }

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