<?php
// Include header CSS
echo '<link rel="stylesheet" type="text/css" href="assets/css/header.css">';
?>

<div class="container">
    <!-- Logo Section -->
    <div class="logo">
        <a href="index.php">
            <img src="assets/images/logo.png" alt="Book Store Logo" />
        </a>
    </div>

    <!-- Navigation Bar -->
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>

    <!-- Search Bar -->
    <div class="search-bar">
        <form action="search.php" method="GET">
            <input type="text" name="query" placeholder="Search for books..." />
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Cart Icon -->
    <div class="cart">
        <a href="cart.php">
            <img src="assets/images/cart-icon.png" alt="Cart">
            <span class="cart-count"><?php ?></span>
        </a>
    </div>
</div>
