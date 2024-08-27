<?php
session_start();
$uid = $_SESSION['uid'];

// Database connection settings
$dbHost     = "localhost"; 
$dbUsername = "root"; 
$dbName     = "teams"; 
$dbPassword = "";

// Establish connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Get data from POST request
$status = $_POST['status'];
$tid = $_POST['tid'];

if (!$status || !$tid) {
    echo json_encode(['success' => false, 'error' => 'Missing status or task ID.']);
    exit;
}

date_default_timezone_set('Asia/Calcutta'); 
$time = date("H:i:s");

// Debug logging
error_log("Status: $status, Task ID: $tid");

// Get the current task data
$query = "SELECT stime FROM tasks WHERE tid='$tid'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(['success' => false, 'error' => 'Failed to fetch task data: ' . mysqli_error($conn)]);
    exit;
}

$row = mysqli_fetch_assoc($result);
$stime = $row['stime'];

// Calculate total time if task is completed
if ($status == "Completed") {
    $etime = $time;

    // Calculate total time taken
    $start_time = strtotime($stime);
    $end_time = strtotime($etime);
    $total_time = gmdate("H:i:s", $end_time - $start_time);

    // Update task with status, end time, and total time
    $query = "UPDATE `tasks` SET `status`='$status', `etime`='$etime' WHERE `tid`='$tid'";
} else if ($status == "In Progress") {
    // Update task with status and start time
    $query = "UPDATE `tasks` SET `status`='$status', `stime`='$time' WHERE `tid`='$tid'";
} else {
    // Update task with only the status (for other statuses)
    $query = "UPDATE `tasks` SET `status`='$status' WHERE `tid`='$tid'";
}

// Execute query and return a response
if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Query failed: ' . mysqli_error($conn)]);
}

mysqli_close($conn);
?>
