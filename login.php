<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$database = "opd_db";

// Connect to database
$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get username & password from form
$username = $_POST['username'];
$password = $_POST['password'];

// Check user in database
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $_SESSION['username'] = $username;
    header("Location: dashboard.php"); // Redirect after login
} else {
    echo "<script>alert('Invalid Credentials!'); window.location.href='login.html';</script>";
}

mysqli_close($conn);
?>
