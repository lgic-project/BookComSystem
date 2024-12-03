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