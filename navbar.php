<!-- navbar.php -->
<nav class="navbar">
    <div class="logo">
        <a href="./index.php">Bookly</a>
    </div>
    <ul class="nav-links">
        <li><a href="./index.php">Home</a></li>
        <li><a href="product.php">Products</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="contact.php">Contact Us</a></li>
    </ul>
    <div class="auth-links">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
        <a href="search.php">Search</a>
        <a href="cart.php">Cart</a>
    </div>
</nav>
