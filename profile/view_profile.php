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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    $updateQuery = "UPDATE patient SET phone='$phone', address='$address' WHERE username='$username'";
    
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Profile Updated!'); window.location.href='view_profile.php';</script>";
    } else {
        echo "<script>alert('Update Failed!');</script>";
    }
}

$query = "SELECT * FROM patient WHERE username='$username'";
$result = mysqli_query($conn, $query);
$patient = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../dashboard_style.css">
</head>
<body>

    <div class="navbar">
        <ul>
            <li><a href="/OPD_Project/dashboard.php">Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Gallery</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>
        <div class="profile">
            <a href="view_profile.php">👤 Profile</a> |
            <a class="logout-btn" href="logout.php">Logout</a>
        </div>
    </div>

    <div class="profile-container">
        <h2>My Profile</h2>
        <form method="POST">
            <label>First Name:</label>
            <input type="text" value="<?= $patient['fname']; ?>" readonly>

            <label>Last Name:</label>
            <input type="text" value="<?= $patient['lname']; ?>" readonly>

            <label>Username:</label>
            <input type="text" value="<?= $patient['username']; ?>" readonly>

            <label>Phone:</label>
            <input type="text" name="phone" value="<?= $patient['phone']; ?>" required>

            <label>Address:</label>
            <input type="text" name="address" value="<?= $patient['address']; ?>" required>

            <button type="submit">Update Profile</button>
        </form>
    </div>

</body>
</html>
