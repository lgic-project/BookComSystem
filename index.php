<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set the default theme if not set
if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'light-mode';
}

// Determine the requested page
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'about':
        include 'about.php';
        break;
    case 'home':
    default:
        include 'home.php';
        break;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website</title>
    
    <!-- Linking external CSS -->
    <link rel="stylesheet" href="css/style.css"> <!-- Make sure the path is correct -->
</head>
<body>
    <!-- Page content -->
</body>
</html>
