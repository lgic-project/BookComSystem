<nav class="navbar">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="index.php?page=about">About Us</a></li>
        <li><a href="index.php?page=products">Products</a></li>
        <li><a href="index.php?page=contact">Contact</a></li>
        <?php if (isset($_SESSION['user'])): ?>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
