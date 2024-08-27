<?php
session_start();
$uid = $_SESSION['uid'];

$host = 'localhost';
$dbname = 'teams'; // Replace with your database name
$user = 'root'; // Replace with your MySQL username
$pass = ''; 
date_default_timezone_set('Asia/Calcutta'); 
$datex = date("Y-m-d");
$datetimex = date("Y-m-d H:i:s");
$timex = date("H:i:s");
$mode = $_POST['mode'];
$latitudex = $_POST['latitudex'];
$longitudex = $_POST['longitudex'];

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Function to get client IP
function getClientIP() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } elseif (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }
    return $ipaddress;
}

$client_ip = getClientIP();
$mapmap = $latitudex . "," . $longitudex;

if ($_POST['typex'] == "punch_in") {
    // Punch in
    $query = "INSERT INTO `attendance`(`sno`, `date_timex`, `datex`, `uid`, `modex`, `punchin`, `punchout`, `total_prod`, `ip_addre`, `lat_lang`) 
              VALUES ('', '$datetimex', '$datex', '$uid', '$mode', '$timex', '', '', '$client_ip', '$mapmap')";
} elseif ($_POST['typex'] == "punch_out") {
    // Punch out
    $last_punchin = $_POST['last_punchin'];
    $time1 = new DateTime($timex);
    $time2 = new DateTime($last_punchin);
    $interval = $time1->diff($time2);
    $final_time = $interval->format('%H:%I:%S');

    $query = "UPDATE `attendance` 
              SET `punchout`='$timex', `total_prod`='$final_time', `ip_addre`='$client_ip', `lat_lang`='$mapmap' 
              WHERE uid='$uid' AND DATE(datex)='$datex' 
              ORDER BY date_timex DESC LIMIT 1";
}

// Execute the query
mysqli_query($conn, $query);

// Redirect to attendance page
header("Location:attendance.php");
?>
