<?php
$host = "localhost";
$user = "root";
$password = ""; // Leave blank for XAMPP default
$database = "divya_desams_108";

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
