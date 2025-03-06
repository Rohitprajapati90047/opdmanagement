<?php
include 'db_connect.php';
$servername = "localhost";
$username = "root";
$password = "";
$database = "opd_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $fname = clean_input($_POST['fname']);
    $lname = clean_input($_POST['lname']);
    $dob = clean_input($_POST['dob']);
    $gender = clean_input($_POST['gender']);
    $phone = clean_input($_POST['phone']);
    $aadhaar = clean_input($_POST['aadhaar']);
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);
    $address = clean_input($_POST['address']);
    $disease = clean_input($_POST['disease']);

    // Validate Aadhaar (ensure it's exactly 12 digits)
    if (!preg_match("/^[0-9]{12}$/", $aadhaar)) {
        die("Error: Invalid Aadhaar Number");
    }

    // Validate phone (ensure it's exactly 10 digits)
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        die("Error: Invalid Phone Number");
    }

    // Validate password length (minimum 6 characters)
    if (strlen($password) < 6) {
        die("Error: Password must be at least 6 characters long.");
    }

    // Hash password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if Aadhaar or Username already exists
    $checkQuery = "SELECT * FROM patient WHERE aadhaar = ? OR username = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $aadhaar, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("Error: Aadhaar or Username already registered.");
    }

    // Insert data into database
    $query = "INSERT INTO patient (fname, lname, dob, gender, phone, aadhaar, username, password, address, disease) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssss", $fname, $lname, $dob, $gender, $phone, $aadhaar, $username, $hashed_password, $address, $disease);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Your username is: $username'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
}

$conn->close();
?>
