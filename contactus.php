<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="email"],
        form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form input[type="submit"] {
            background-color: #6200ea;
            color: #fff;
            padding: 15px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
        }

        form input[type="submit"]:hover {
            background-color: #3700b3;
        }

        .info-section {
            text-align: center;
        }

        .info-section a {
            text-decoration: none;
            color: #6200ea;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Contact Us</h1>

        <!-- Contact Form -->
        <form action="submit_contact.php" method="POST">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Your Full Name" required>

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="number">Contact Number</label>
            <input type="text" id="number" name="number" placeholder="Enter your phone number" required>

            <label for="message">Your Message</label>
            <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>

            <input type="submit" value="Submit">
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