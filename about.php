<?php

// Start the session
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="./css/aboutus.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'header.php'; ?>

    <section class="about-us">
        <div class="about-com">
            <h1>About Us</h1>
            <h3>Welcome to Bookly!</h3>
            <p>
                At <strong>Bookly</strong>, we bring the world of stories, knowledge, and inspiration right to your
                doorstep. We are committed to offering readers a vast and diverse collection of books at affordable
                prices, catering to every interest and age group. Whether you're into <em>Fiction, Non-fiction, Science,
                    History, or Self-Help</em>, we have something for every kind of reader.
            </p>

            <h3>Our Mission</h3>
            <p>
                Our mission at <strong>Bookly</strong> is simple:
            </p>
            <ul>
                <li><span>📖</span> Make books accessible to everyone in Nepal and beyond.</li>
                <li><span>🌟</span> Support local authors and celebrate talent.</li>
                <li><span>🤝</span> Create a community of readers who share knowledge, stories, and creativity.</li>
            </ul>

            <h3>Why Choose Bookly?</h3>
            <div class="features">
                <div class="feature">
                    📖 <strong>Vast Collection</strong>: A wide variety of books across genres like Fiction,
                    Non-fiction, Science, History, Self-help, and Educational materials.
                </div>
                <div class="feature">
                    💰 <strong>Affordable Prices</strong>: Get great books at unbeatable prices without compromising on
                    quality.
                </div>
                <div class="feature">
                    🚀 <strong>Fast Delivery</strong>: Ensuring a quick and hassle-free delivery experience across
                    Nepal.
                </div>
                <div class="feature">
                    🌐 <strong>Easy Navigation</strong>: A smooth and intuitive interface for hassle-free browsing and
                    searching.
                </div>
                <div class="feature">
                    💖 <strong>Local Talent Support</strong>: Promoting books from Nepalese authors and giving a
                    platform to our local literary community.
                </div>
            </div>
        </div>

        <section class="about-dev">
            <h3>About Developers</h3>
            <div class="developers">

                <div class="profile-card">
                    <div class="image">
                        <img src="./developerpic/deepak.jpg" alt="Deepak Photo" class="profile-img">
                    </div>
                    <div class="text-data">
                        <span class="name">Deepak Chhantyal</span>
                        <span class="job">Developer</span>
                    </div>
                    <div class="media-buttons">
                        <a href="https://www.facebook.com/profile.php?id=100012898502822" target="_blank"
                            style="background: #4267b2" class="link"> <i class="fab fa-facebook"></i> </a>
                        <a href="https://www.instagram.com/deepak_chhantyal/" target="_blank"
                            style="background: #e1306c" class="link"> <i class="fab fa-instagram"></i> </a>
                        <a href="https://github.com/deepak4156" target="_blank" style="background: #000" class="link">
                            <i class="fab fa-github"></i> </a>
                        <a href="https://www.linkedin.com/in/deepak-chhantyal-4a5ab0165/" target="_blank"
                            style="background: #0077b5" class="link"> <i class="fab fa-linkedin"></i> </a>
                    </div>
                </div>

                <div class="profile-card">
                    <div class="image">
                        <img src="./developerpic/bishal.jpg" alt="Bishal Photo" class="profile-img">
                    </div>
                    <div class="text-data">
                        <span class="name">Bishal Adhikari</span>
                        <span class="job">Developer</span>
                    </div>
                    <div class="media-buttons">
                        <a href="https://www.facebook.com/bishal.adkary.1" target="_blank" style="background: #4267b2"
                            class="link"> <i class="fab fa-facebook"></i> </a>
                        <a href="https://www.instagram.com/bwi_sal/" target="_blank" style="background: #e1306c"
                            class="link"> <i class="fab fa-instagram"></i> </a>
                        <a href="https://github.com/BishalAdhikari0123" target="_blank" style="background: #000"
                            class="link"> <i class="fab fa-github"></i> </a>
                        <a href="https://www.linkedin.com/in/bishal-adhikari-051a09296/" target="_blank"
                            style="background: #0077b5" class="link"> <i class="fab fa-linkedin"></i> </a>
                    </div>
                </div>

                <div class="profile-card">
                    <div class="image">
                        <img src="./developerpic/roshan.JPG" alt="Roshan Photo" class="profile-img">
                    </div>
                    <div class="text-data">
                        <span class="name">Roshan Adhikari</span>
                        <span class="job">Developer</span>
                    </div>
                    <div class="media-buttons">
                        <a href="https://www.facebook.com/roshan.adhikari.31149" target="_blank"
                            style="background: #4267b2" class="link"> <i class="fas fa-facebook"></i> </a>
                        <a href="https://www.instagram.com/name.is.sabeen/" target="_blank" style="background: #e1306c"
                            class="link"> <i class="fas fa-instagram"></i> </a>
                    </div>
                </div>

            </div>
        </section>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>