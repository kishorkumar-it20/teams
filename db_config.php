<?php 
 
// Database configuration   
$dbHost     = "localhost"; 
$dbUsername = "root"; 
$dbName     = "teams"; 
$dbPassword = "";
 
date_default_timezone_set('Asia/Calcutta'); 
// Create database connection 
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 
 
// Check connection 
if ($db->connect_error) { 
    die("Connection failed: " . $db->connect_error); 
} 
 
?>