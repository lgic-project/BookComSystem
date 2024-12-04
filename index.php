<?php
// session_start();

// if (!isset($_SESSION['username'])) {
//     header('Location: login.php');
//     exit();
// }

// $username = $_SESSION['username']; // Fetch the logged-in username from session (in real app)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sasto E-Pasal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <!-- for font and icons -->
    <link rel="stylesheet" href="./css/style.css"> <!-- Main stylesheet -->
    <link rel="stylesheet" href="./css/footer.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <main>
        <?php
        // Check for the 'page' parameter in the URL to dynamically load content
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            switch ($page) {
                case 'about':
                    include 'about.php'; // Include about.php when the 'about' page is requested
                    break;
                // Add other cases for different pages as needed
                default:
                    include 'home.php'; // Default page if no page is specified
            }
        } else {
            include 'home.php'; // Default page if no page is specified
        }
        ?>
    </main>
    <?php include 'about.php'; ?>
    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script src="./js/script.js"></script> <!-- Main JavaScript -->
</body>

</html>
