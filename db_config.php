<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "wadap_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>