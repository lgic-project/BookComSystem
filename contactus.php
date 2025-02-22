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
    <title>Bookly | Contact Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Contact Us</h1>

        <form class="contactForm" action="mail.php" method="post">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Your Full Name" required>

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="subject">Subject</label>
            <input type="text" id="number" name="subject" placeholder="Enter your subject" required>

            <label for="message">Your Message</label>
            <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>

            <input type="submit" name="send" value="Send Message">
        </form>

        <!-- Company Info Section -->
        <div class="info-section">
            <h3>Our Contact Information</h3>
            <p><i class="fas fa-map-marker-alt"></i> Address: Bookly, Chipledhunga, Pokhara</p>
            <p><i class="fas fa-phone"></i> Phone: +977 987665905</p>
            <p><i class="fas fa-envelope"></i> Email: <a href="mailto:bsaladkari@gmail.com">bsaladkari@gmail.com</a></p>
            <p>Follow us on:</p>
            <a href="https://www.facebook.com" target="_blank" class="btn">Facebook</a>
            <a href="https://www.instagram.com" target="_blank" class="btn">Instagram</a>
            <a href="https://github.com" target="_blank" class="btn">GitHub</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>

</html>