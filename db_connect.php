<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "opd_management";
$port = 3306; // Change to 3309 if needed

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
