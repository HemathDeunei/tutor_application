<?php
session_start();

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
  $Protocol = "https://";
}else{
  $Protocol = "http://";
}

define("SITE_URL",$Protocol.$_SERVER['SERVER_NAME']); 
define("ROOT",$_SERVER['DOCUMENT_ROOT'].""); 
define("UPLOAD_PATH",$_SERVER['DOCUMENT_ROOT']."/uploads"); 
define("UPLOAD_URL",SITE_URL."/assets/uploads"); 

define("PROFILE",UPLOAD_URL."/profiles/"); 
define("COURSES",UPLOAD_URL."/courses/"); 


$servername = "localhost";
$username   = "deuneic1_siteadmin";
$password   = "admin@3112";
$db         = "deuneic1_tutor";

// Create connection
$conn =  mysqli_connect($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//  echo "Connected successfully";

?>