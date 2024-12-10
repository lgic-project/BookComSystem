<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'light-mode';
}



// Determine the requested page

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
    <?php include 'header.php'; 
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
    $page = isset($_GET['page']) ? $_GET['page'] : 'products';

    ?>
    <!-- Page content -->
</body>
</html>
