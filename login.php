<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$database = "opd_management";

// Connect to database
$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get input values
$input = $_POST['username']; // Can be Username OR Aadhaar
$password = $_POST['password'];

// Check if input is Aadhaar (12-digit number) or Username
if (preg_match("/^[0-9]{12}$/", $input)) {
    $sql = "SELECT * FROM patient WHERE aadhaar = ?";
} else {
    $sql = "SELECT * FROM patient WHERE username = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $input);
$stmt->execute();
$result = $stmt->get_result();

// Verify login
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verify Password
    if (password_verify($password, $row['password'])) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['aadhaar'] = $row['aadhaar'];
        header("Location: dashboard.php"); // Redirect after login
    } else {
        echo "<script>alert('Invalid Password!'); window.location.href='login.html';</script>";
    }
} else {
    echo "<script>alert('Invalid Username or Aadhaar!'); window.location.href='login.html';</script>";
}

$stmt->close();
$conn->close();
?>
