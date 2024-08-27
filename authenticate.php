<?php
// Database connection
$host = 'localhost';
$dbname = 'teams'; // Replace with your database name
$user = 'root'; // Replace with your MySQL username
$pass = ''; 

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the form
$username = $_POST['username'];
$password = $_POST['password']; // Not recommended for real applications, use password_hash and password_verify instead

// SQL query to fetch the user
$sql = "SELECT * FROM members WHERE uname='$username' AND password='$password'";
$result = $conn->query($sql);
$uid = $result->fetch_assoc();

if ($result->num_rows > 0) {
    // Login successful
     //echo "Login successful!";
    // Here, you would typically set session variables and redirect the user to another page
    session_start();
$_SESSION['uid'] = $uid['id'];
$_SESSION['namex'] = $uid['name'];
    
    header("Location: dashboard.php");
} else {
    // Login failed
    echo "Invalid username or password!";
    header("Location: index.php");
}

$conn->close();
?>
