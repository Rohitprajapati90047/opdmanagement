<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$database = "opd_management";
$conn = mysqli_connect($host, $user, $password, $database);

$username = $_SESSION['username'];
$query = "SELECT * FROM patient WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$patient = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - OPD Management</title>
    <link rel="stylesheet" href="dashboard_style.css">
    
</head>
<body>

    <div class="navbar">
        <ul>
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Gallery</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>
        <div class="profile">
            <a href="profile/view_profile.php">👤 Profile</a> |
            <a class="logout-btn" href="logout.php">Logout</a>
        </div>
    </div>

    <?php if(isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

    <div class="dashboard-container">
        <button onclick="window.location.href='renew_case.php'">RENEW CASE PAPER</button>
        <button onclick="window.location.href='patient_report.php'">Patient Report</button>
        <button onclick="window.location.href='disease_medicine.php'">Disease and Medicine</button>
        <button onclick="window.location.href='billing.php'">Billing</button>
        <button onclick="window.location.href='operation_info.php'">Operation Info</button>
        <button onclick="window.location.href='lab_report.php'">Laboratory Report</button>
        <button onclick="window.location.href='transfer_opd.php'">Transfer OPD</button>
        <button onclick="window.location.href='manage_account.php'">Manage Account</button>
    </div>

</body>
</html>
