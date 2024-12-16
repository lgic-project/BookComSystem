<?php
// Start the session if not started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set default theme if not set
if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'light-mode'; // Default theme
}

// Update theme if requested
if (isset($_POST['theme'])) {
    $_SESSION['theme'] = $_POST['theme'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Header</title>
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
</head>
<body class="<?php echo $_SESSION['theme']; ?>">
<header class="header">
    <div class="header-container">
        <!-- Logo -->
        <div class="logo">
            <a href="index.php"><img src="logo/logo-no-slogan-removebg-preview.png" alt="Logo"></a>
        </div>

        <!-- Navigation Bar -->
        <nav class="nav-bar">
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li>
                    <a href="category.php">Categories <i class="fas fa-caret-down"></i></a>
                    <div class="dropdown_menu">
                        <ul>
                            <li><a href="#">Fantasy</a></li>
                            <li><a href="#">Sci-Fi</a></li>
                            <li><a href="#">Biography</a></li>
                            <li><a href="#">Self-Help</a></li>
                            <li><a href="#">Mystery/Thriller</a></li>
                            <li><a href="#">Romance</a></li>
                            <li><a href="#">Horror</a></li>
                            <li><a href="#">History</a></li>
                            <li><a href="#">Other</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
            </ul>
        </nav>

        <!-- Search Bar and Cart -->
        <div class="header-right">
            <div class="search-bar">
                <form action="search.php" method="GET">
                    <input type="text" name="query" placeholder="Search for books..." />
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="cart">
                <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
    </div>
</header>
</body>
</html>