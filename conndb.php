<?php
$hostname = "127.0.0.1";
$username = "root";
$password = "Mackey";
$dbname = "finaldb";

// Create connection
$conn = new mysqli($hostname, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // echo "Connected successfully!";
}