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
    <title>Dashboard - Sasto E-Pasal</title>
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="./css/footer.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <section class="home">
        <div class="content">
            <h3>Book from the bookstore </h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere corporis temporibus dolor enim unde?
                Placeat veniam atque in voluptatum facere. Qui, quasi maxime! Animi, illo et facilis esse quo quas?</p>
            <a href="about.php" class="white-btn">Discover</a>
        </div>
    </section>
    <section class="latest-product">
        <h3>Latest Product</h3>
    </section>
    <section class="about-us">
        <h3>About Us</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam debitis in porro libero cum magni repudiandae
            aperiam itaque ab laudantium vitae pariatur recusandae aut, assumenda accusamus ad magnam. Illum, omnis.
        </p>
        <a href="about.php">Know More</a>
    </section>
    <?php include 'footer.php' ?>
</body>

</html>