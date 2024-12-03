<?php
// session_start();

// if (!isset($_SESSION['username'])) {
//     header('Location: login.php');
//     exit();
// }

// $username = $_SESSION['username']; // Fetch the logged-in username from session (in real app)
// ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sasto E-Pasal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- for font and icons -->
    <link rel="stylesheet" href="./css/style.css"> <!-- Main stylesheet -->
    <link rel="stylesheet" href="./css/footer.css">
</head>

<body>
    <header class="header">
        <nav>
            <div class="nav-bar">
                <span class="logo"><a href="#">BookPasal</a></span>

                <div class="menu">
                    <ul class="nav-links">
                        <li><a href="./index.php">Home</a> </li>
                        <li><a href="#">Products</a> </li>
                        <li><a href="#">Categories</a> </li>
                        <li><a href="#">About Us</a> </li>
                        <li><a href="#">Contact Us</a> </li>
                    </ul>
                </div>
                <div class="login">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>


    <!-- Main Content -->
    <main>
        <?php
        // Routing logic to dynamically load content
        // if (isset($_GET['page'])) {
        //     $page = $_GET['page'];
        //     switch ($page) {
        //         case 'about':
        //             include 'about.php';
        //             break;
        //         case 'contact':
        //             include 'contact.php';
        //             break;
        //         case 'products':
        //             include 'products.php';
        //             break;
        //         default:
        //             include 'homepage.php';
        //     }
        // } else {
        //     include 'homepage.php'; // Default page
        // }
        ?>

    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script src="./js/script.js"></script> <!-- Main JavaScript -->
</body>

</html>