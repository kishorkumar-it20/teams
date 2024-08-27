<?php session_start();
$uid = $_SESSION['uid'];
    

// Database connection
$dbHost     = "localhost"; 
$dbUsername = "root"; 
$dbName     = "teams"; 
$dbPassword = "";
date_default_timezone_set('Asia/Calcutta'); 
$datex = date("Y-m-d");
$timex = date("H:i:s");
$desc = $_POST['desc'];
$prior = $_POST['priority'];
$time_est = $_POST['time_est'];
$company = $_POST['company'];
$status = "Open";

// Create connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
$query = "INSERT INTO `tasks`(`tid`, `date`, `time`, `uid`, `task_desc`, `priority`, `estimation`, `status`, `stime`, `etime`, `comments`, `reviewer`, `review`, `review_dt`, `company`, `review_status`) VALUES ('','$datex','$timex','$uid','$desc','$prior','$time_est','$status','','','','','','','$company','')";
mysqli_query($conn,$query);
header("Location:Task.php");

?>