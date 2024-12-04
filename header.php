<header class="header">
    <div class="header-1">
        <h1 class="logo"> <a href="./index.php">Bookly</a> </h1>

    </div>
    <nav class="header-2">
        <div class="nav-bar">
            <div class="menu">
                <ul class="nav-links">
                    <li><a href="./index.php">Home</a> </li>
                    <li><a href="product.php">Products</a> </li>
                    <li><a href="category.php">Categories <i class="fas fa-caret-down"></i> </a>

                    <div class="dropdown_menu">
                        <ul>
                            <li><a href="">Fantasy</a></li>
                            <li><a href="">Sci-Fi</a></li>
                            <li><a href="">Biography</a></li>
                            <li><a href="">Self-Help</a></li>
                            <li><a href="">Biography</a></li>
                            <li><a href="">Mystery/Thriller</a></li>
                            <li><a href="">Romance</a></li>
                            <li><a href="">Horror</a></li>
                            <li><a href="">History</a></li>
                            <li><a href="">Other</a></li>
                        </ul>
                    </div>

                    </li>
                    <li><a href="about.php">About Us</a> </li>
                    <li><a href="contact.php">Contact us</a> </li>
                </ul>
            </div>
            <div class="nav-2">
                <a href="./search.php"> Search</a>
                <div class="login">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </div>
                <a href="">Cart</a>
            </div>
        </div>
    </nav>
</header>