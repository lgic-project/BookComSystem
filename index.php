<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'light-mode';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website</title>

    <!-- Linking external CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<?php 
// Determine the page to include
// $page = isset($_GET['page']) ? $_GET['page'] : 'home';

// echo "<p>Current Page: " . htmlspecialchars($page) . "</p>"; // Debug current page

// if ($page === 'about') {
//     if (file_exists('about.php')) {
//         echo "<p>Loading About Page...</p>"; // Debug inclusion of about.php
//         include 'about.php';
//     } else {
//         echo "<p>Error: about.php file not found.</p>";
//     }
// } else {
//     if (file_exists('home.php')) {
//         include 'home.php';
//     } else {
//         echo "<p>Error: home.php file not found.</p>";
//     }
// }

include 'footer.php';
?>

</body>
</html>
