<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "recruitment_system";

// Create a connection
$conn = new mysqli($host, $user, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
