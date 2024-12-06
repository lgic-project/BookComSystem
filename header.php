<head>
    <!-- <link rel="stylesheet" href="header.css"> -->
</head>
<header class="header">
    <div class="header-1">
        <h1 class="logo">
            <a href="bookspic/"><img class="logo-pic" src="bookspic/logo-no-slogan-removebg-preview.png" alt="Logo"></a>
        </h1>
    </div>

    <nav class="header-2">
        <div class="nav-bar">
            <ul class="nav-links">
                <li><a href="./index.php">Home</a></li>
                <li><a href="product.php">Products</a></li>
                <li><a href="category.php">Categories <i class="fas fa-caret-down"></i></a>
                    <div class="dropdown_menu">
                        <ul>
                            <li><a href="">Fantasy</a></li>
                            <li><a href="">Sci-Fi</a></li>
                            <li><a href="">Biography</a></li>
                            <li><a href="">Self-Help</a></li>
                            <li><a href="">Mystery/Thriller</a></li>
                            <li><a href="">Romance</a></li>
                            <li><a href="">Horror</a></li>
                            <li><a href="">History</a></li>
                            <li><a href="">Other</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="index.php?page=about">About Us</a></li>
                <li><a href="contact.php">Contact us</a></li>
            </ul>
        </div>
    </nav>

    <!-- Theme Toggle Form -->
    <form action="index.php" method="POST" class="theme-toggle-form">
        <button type="submit" name="theme" value="<?php echo ($_SESSION['theme'] == 'light-mode') ? 'dark-mode' : 'light-mode'; ?>" class="theme-toggle">
            Switch Theme
        </button>
    </form>
</header>
