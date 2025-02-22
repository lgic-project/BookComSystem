<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username']; // Fetch the logged-in username from session (in real app)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookly | Dashboard</title>
    <link rel="stylesheet" href="./css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="navbar">
            <h2>E-Pasal</h2>
            <div class="navbar-links">
                <a href="profile.php">My Profile</a>
                <a href="shop.php">Shop</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        
        <div class="main-content">
            <h3>Your Dashboard</h3>
            <div class="content-box">
                <h4>Account Overview</h4>
                <p>View your account details, past orders, and other information here.</p>
                <a href="order-history.php" class="btn">View Order History</a>
            </div>
            <div class="content-box">
                <h4>Special Offers</h4>
                <p>Check out exclusive offers for our registered users.</p>
                <a href="offers.php" class="btn">View Offers</a>
            </div>
        </div>
    </div>
</body>
</html>
