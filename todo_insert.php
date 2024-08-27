<?php 
session_start();
$uid = $_SESSION['uid'];
$namex = $_SESSION['namex']; 

$host = 'localhost';
$dbname = 'teams'; // Replace with your database name
$user = 'root'; // Replace with your MySQL username
$pass = ''; // MySQL password

date_default_timezone_set('Asia/Calcutta'); 
$datex = date("Y-m-d H:i:s");
$desc = $_POST['desc'];
$tox = $_POST['tox'];
$prior = $_POST['priority'];
$complexity = $_POST['complexity'];
$deadline = $_POST['deadline'];
$company = $_POST['company'];
$status = "Open";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "INSERT INTO `todo`(`tid`, `date_time`, `description`, `fromx`, `tox`, `forx`, `priorx`, `deadlinex`, `statusx`, `complexity`) VALUES ('','$datex','$desc','$uid','$tox','$company','$prior','$deadline','$status','$complexity')";

// Execute the query
if ($conn->query($query) === TRUE) {
    header("Location: TodoIassigned.php");
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
