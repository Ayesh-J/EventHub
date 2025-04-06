<?php
$host = "localhost"; // Change if your database is hosted remotely
$username = "root"; // Your MySQL username (default: root)
$password = ""; // Your MySQL password (leave empty if none)
$database = "eventhub"; // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>
