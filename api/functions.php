<?php
function UploadImageFile($image){
    try 
    {
        $uploadDirectory = PROFILE_UPLOAD_PATH . '/';
        $uploadURL       = PROFILE;
        $image_file_path = "";

        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        $file_ext  =    pathinfo($_FILES["$image"]['name'], PATHINFO_EXTENSION);
        $file_name = $_FILES["$image"]["name"];
        $file_tmp  = $_FILES["$image"]["tmp_name"];
        $ext       = pathinfo($file_name, PATHINFO_EXTENSION);

        if (in_array($ext, ['jpeg', 'jpg', 'png', 'gif','PNG', 'jfif'])) {
            $newFileName = uniqid("profile_") . "." . $file_ext;
            $uploadPath = $uploadDirectory . $newFileName;


            if (move_uploaded_file($file_tmp, $uploadPath)) {
                // $image_file_path= $uploadURL . $newFileName;
                $image_file_path = $newFileName;

            }
        }

        return $image_file_path;

    } catch (Exception $ex) {
        return "Upload Error : ".$ex->getMessage();
    }
}

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
    $Query      = "SELECT * FROM pre_tutor_courses WHERE course_id = '".$cid."' AND tutor_id ='".$tid."'";
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
    $Query      = "SELECT * FROM pre_users WHERE id = '".$sid."'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            return $record;


        }

    }


}

function getUserDetails($conn, $uid)
{
    $Query      = "SELECT * FROM pre_users WHERE id = '".$uid."'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            return $record;


        }

    }


}

function getPackageDetails($conn, $pid)
{
    $Query      = "SELECT * FROM pre_packages WHERE id = '".$pid."'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            return $record;


        }

    }


}

function getTutoringCourses($conn, $tid)
{
    $Query      = "select count(*) courses from pre_bookings where tutor_id=".$tid;
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            return $record["courses"];
        }

    }
}

function getTutorsRunningBookings($conn, $tid)
{

    $Query      = "select count(*) running_bookings from pre_bookings where tutor_id=".$tid." And status='running'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            return $record["running_bookings"];
        }

    }
}

function getTutorsCompletedBookings($conn, $tid)
{
    
    $Query      = "select count(*) completed_bookings from pre_bookings where tutor_id=".$tid." And status='completed'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            return $record["completed_bookings"];
        }

    }
}

function getTutorsTotalBookings($conn, $tid)
{
    $Query      = "select count(*) total_bookings from pre_bookings where tutor_id = '".$tid."'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            return $record["total_bookings"];
        }

    }
}

function getTutorsPendingBookings($conn, $tid)
{
    $Query      = "select count(*) pending_bookings from pre_bookings where tutor_id = '".$tid."' And status='pending'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            return $record["pending_bookings"];
        }

    }
}

function getTotalBookings($conn, $sid)
{
    $Query      = "select count(*) total_bookings from pre_bookings where student_id = '".$sid."'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            return $record["total_bookings"];
        }

    }
}

function getPendingBookings($conn, $sid)
{
    $Query      = "select count(*) pending_bookings from pre_bookings where student_id = '".$sid."' And status='pending'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            return $record["pending_bookings"];
        }

    }
}

function getTutorDetails($conn, $tid)
{
    $Query      = "SELECT * FROM pre_users WHERE id = '".$tid."'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            return $record;


        }

    }


}

function getBookingDetails($conn, $sid, $tid, $cid)
{
    $Query      = "SELECT * FROM pre_bookings WHERE student_id = '".$sid."' AND course_id = '".$cid."' AND tutor_id ='".$tid."'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
    
            return $record;


        }

    }else{
        return false;
    }
}

function getCourse($conn, $cid)
{
    $Query      = "SELECT * FROM pre_categories WHERE id = '".$cid."'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
    
            return $record;


        }

    }else{
        return false;
    }
}

function getLocations($conn, $tutor){
    $Query      = "SELECT * FROM pre_locations WHERE parent_location_id = '0'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            $data = array();
            $data["state"]          = $record["location_name"];
            $data["city"]           = getSubLocations($conn, $record["id"], $tutor);

            array_push($ListArray,$data);

        }

    }

    return $ListArray;

}

function getSubLocations($conn, $pid, $tutor){
    $Query      = "SELECT * FROM pre_locations WHERE parent_location_id = '".$pid."'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            $data = array();
            $data["city_id"]          = $record["id"];
            $data["city_name"]        = $record["location_name"];
            $data["city_status"]      = getTutorLocations($conn, $record["id"], $tutor);

            array_push($ListArray,$data);

        }

    }

    return $ListArray;

}

function getTutorLocations($conn, $id, $tutor){
    $Query      = "SELECT * FROM pre_tutor_locations WHERE tutor_id = '".$tutor."' AND location_id = '".$id."'";
    $Results    = mysqli_query($conn,$Query);
    $ListArray  = array();

    if (mysqli_num_rows($Results) > 0) 
    {
        while($record = mysqli_fetch_assoc($Results)) 
        {
            return 'Y';
        }

    }else{
        return 'N';
    }
}
?>