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

?>