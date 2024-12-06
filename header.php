<!-- <?php 
// Start the session only if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'light-mode'; // Default theme
}

// Toggle the theme
if (isset($_POST['theme'])) {
    $_SESSION['theme'] = $_POST['theme'];
}
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="css/header.css">
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<!-- <body class="<?php echo $_SESSION['theme']; ?>"> -->

<header class="header">
    <div class="header-container">
        <!-- Logo -->
        <div class="logo">
            <a href="index.php"><img src="logo/logo-no-slogan-removebg-preview.png  " alt="Logo"></a>
        </div>

        <!-- Navigation Links -->
        <nav class="nav-bar">
            <ul class="nav-links">
                <li><a href="./index.php">Home</a></li>
                <li><a href="product.php">Products</a></li>
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
                <li><a href="index.php?page=about">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>

        <!-- Right Section: Search Bar, Cart, Theme Toggle -->
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

            <!-- <form action="" method="POST" class="theme-toggle-form">
                <label class="toggle-switch">
                    <input type="hidden" name="theme" value="<?php echo ($_SESSION['theme'] === 'light-mode') ? 'dark-mode' : 'light-mode'; ?>">
                    <input type="checkbox" onchange="this.form.submit()" <?php echo ($_SESSION['theme'] === 'dark-mode') ? 'checked' : ''; ?>>
                    <span class="slider"></span>
                </label>
            </form> -->
        </div>
    </div>
</header>

</body>
</html>
