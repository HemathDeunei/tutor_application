<?php

function getTutorCourses($conn, $id){
    $Query      = "SELECT *, (SELECT name from pre_categories WHERE id = tc.course_id) AS name FROM pre_tutor_courses AS tc WHERE tc.tutor_id ='".$id."'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
    
       
            array_push($ListArray,$record["name"]);

        }

    }

    return $ListArray;

}

function getTeachingTypes($conn, $id){
    $Query      = "SELECT * FROM pre_tutor_teaching_types WHERE tutor_id ='".$id."'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            if($record["teaching_type_id"] == "1"){
                array_push($ListArray,"Home");
            }else if($record["teaching_type_id"] == "3"){
                array_push($ListArray,"Online");
            }
        }

    }

    return $ListArray;

}

function getSelectedTutorCourses($conn, $tid, $cid){
    $Query      = "SELECT * FROM pre_tutor_courses AS tc WHERE tc.course_id = '".$cid."' AND tc.tutor_id ='".$tid."'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            $data = array();
            $data["tutor_id"]           = $record["tutor_id"];
            $data["course_id"]          = $record["course_id"];
            $data["time_slots"]         = $record["time_slots"];
            $data["mode"]               = getTeachingTypes($conn, $record["tutor_id"]);
            $data["credits"]            = $record["fee"];
            $data["duration"]           = $record["duration_value"] ." ". $record["duration_type"];
            $data["days_off"]           = $record["days_off"];

            $CQuery      = "SELECT * FROM pre_categories WHERE id = '".$record["course_id"]."'";
            $CResults    = mysqli_query($conn,$CQuery);
            if (mysqli_num_rows($CResults) > 0) 
            {
                while($crecord = mysqli_fetch_assoc($CResults)) 
                {
                    $data["name"]           = $crecord["name"];
                    $data["image"]          = COURSES . $crecord["image"];
                }
            }

            // array_push($ListArray,$data);

        }

    }

    return $data;

}

function getTutorCourseDetails($conn, $tid, $cid)
{
    $Query      = "SELECT *, (SELECT name from pre_categories WHERE id = tc.course_id) AS name FROM pre_tutor_courses AS tc WHERE tc.course_id = '".$cid."' tc.tutor_id ='".$tid."'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
    
            return $record;

            // array_push($ListArray,$record["name"]);

        }

    }


}


function getStudentDetails($conn, $sid)
{
    $Query      = "SELECT * pre_users WHERE id = '.$sid.'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            $ListArray["username"]  = $record["username"];


        }

    }

    return $ListArray;

}
?>