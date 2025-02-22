<?php
require_once './connection/config.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch featured books (limit 8)
$sqlFeatured = "SELECT id, title, author, price, book_img FROM books LIMIT 8";
$resultFeatured = $mysqli->query($sqlFeatured);

// Fetch latest books based on publication year (limit 8)
$sqlLatest = "SELECT id, title, author, price, book_img FROM books ORDER BY pub_year DESC LIMIT 8";
$resultLatest = $mysqli->query($sqlLatest);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Commercial Site</title>
    <link rel="stylesheet" href="css/home.css">
    <style>
        /* 🔥 Enhanced Banner */
        .banner {
            position: relative;
            background: url('bookspic/bg4.jpg') no-repeat center center/cover;
            height: 50vh;
            display: flex;
    flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 100px 20px;
            color: white;
            /* font-family: 'Poppins', sans-serif; */
            font-size: 1.2rem;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }

        .banner::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Dark overlay for better readability */
        }

        .banner h1 {
            font-size: 2.5rem;
            font-weight: bold;
            z-index: 2;
            position: relative;
        }

        .banner p {
            font-size: 1.2rem;
            font-weight: 300;
            z-index: 2;
            position: relative;
        }

        /* 📚 Scrollable Book Container */
        .scroll-container {
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            gap: 15px;
            padding: 10px;
            scroll-behavior: smooth;
            scrollbar-width: thin;
            /* Makes scrollbar less intrusive */
            scrollbar-color: #6200ea transparent;
        }

        /* Hide Scrollbar in WebKit Browsers */
        .scroll-container::-webkit-scrollbar {
            display: none;
        }

        /* 🔥 Book Card Styling */
        .book-card {
            flex: 0 0 auto;
            width: 220px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
            text-align: center;
            padding: 15px;
            background: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .book-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .book-card img {
            width: 100%;
            height: 230px;
            object-fit: cover;
            border-radius: 8px;
        }

        .book-card h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 10px 0 5px;
            color: #333;
        }

        .book-card p {
            font-size: 14px;
            color: #777;
        }

        .book-card .price {
            font-weight: bold;
            color: #ff4081;
            font-size: 16px;
            margin-top: 5px;
        }

        /* 📌 Section Titles */
        .book-grid h2 {
            text-align: center;
            margin-bottom: 15px;
            font-size: 24px;
            color: #222;
            font-weight: 600;
        }

        /* 🌎 Responsive Design */
        @media (max-width: 768px) {
            .banner {
                height: 40vh;
                font-size: 1rem;
            }

            .banner h1 {
                font-size: 2rem;
            }

            .banner p {
                font-size: 1rem;
            }

            .book-card {
                width: 180px;
            }

            .book-card img {
                height: 200px;
            }
        }

        /* 📝 About Section Styling */
        .about {
            text-align: center;
            padding: 40px 20px;
            background: #f9f9f9;
            border-radius: 10px;
            margin: 30px auto;
            max-width: 800px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .about h2 {
            font-size: 28px;
            color: #222;
            margin-bottom: 15px;
        }

        .about p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .about h3 {
            font-size: 20px;
            color: #444;
            margin-top: 20px;
        }

        .about ul {
            list-style: none;
            padding: 0;
        }

        .about ul li {
            font-size: 16px;
            color: #666;
            padding: 5px 0;
        }

        /* 📌 View Details Button */
        .view-btn {
            display: block;
            width: 100%;
            text-align: center;
            background: #6200ea;
            color: white;
            padding: 8px 0;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
            transition: 0.3s ease;
        }

        .view-btn:hover {
            background: #3700b3;
        }
    </style>
</head>

<body>

    <!-- Banner Section -->
    <section class="banner">
        <h1>WELCOME TO BOOKLY</h1>
        <p>A book a day keeps reality away!!</p>
    </section>

    <!-- Featured Books Section -->
    <section class="book-grid">
        <h2>Featured Books</h2>
        <div class="scroll-container">
            <?php
            if ($resultFeatured->num_rows > 0) {
                while ($row = $resultFeatured->fetch_assoc()) {
                    echo '<div class="book-card">';
                    echo '<img src="./bookspic/' . htmlspecialchars($row['book_img']) . '" alt="' . htmlspecialchars($row['title']) . '">';
                    echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                    echo '<p>by ' . htmlspecialchars($row['author']) . '</p>';
                    echo '<p class="price">Rs.' . htmlspecialchars($row['price']) . '</p>';
                    echo '<a href="view_details.php?id=' . htmlspecialchars($row['id']) . '" class="view-btn">View Details</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No featured books available</p>';
            }
            ?>
        </div>
    </section>

<!-- Latest Books Section -->
<section class="book-grid">
    <h2>Latest Books</h2>
    <div class="scroll-container">
        <?php
        if ($resultLatest->num_rows > 0) {
            while ($row = $resultLatest->fetch_assoc()) {
                echo '<div class="book-card">';
                echo '<img src="./bookspic/' . htmlspecialchars($row['book_img']) . '" alt="' . htmlspecialchars($row['title']) . '">';
                echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                echo '<p>by ' . htmlspecialchars($row['author']) . '</p>';
                echo '<p class="price">$' . htmlspecialchars($row['price']) . '</p>';
                echo '<a href="view_details.php?id=' . htmlspecialchars($row['id']) . '" class="view-btn">View Details</a>';
                echo '</div>';
            }
        } else {
            echo '<p>No latest books available</p>';
        }
        ?>
    </div>
</section>

    <!-- About Section -->
    <section class="about">
        <h2>📖 About Us</h2>
        <p>Welcome to <strong>Bookly</strong>, your ultimate online bookstore! We bring the joy of reading to your
            fingertips, offering a diverse collection of books across various genres.</p>

        <h3>🌟 Our Mission</h3>
        <ul>
            <li>📚 To make books accessible and affordable for everyone.</li>
            <li>🌍 To promote a culture of reading and knowledge sharing.</li>
            <li>💡 To support and showcase talented authors from all backgrounds.</li>
        </ul>

        <h3>📌 Why Choose Us?</h3>
        <p>We offer:</p>
        <ul>
            <li>✔️ A vast collection of books in different categories.</li>
            <li>✔️ Competitive pricing and regular discounts.</li>
            <li>✔️ A seamless shopping experience with secure payment options.</li>
        </ul>

        <p>Join us in our journey to create a world where books are more than just words on paper—they're gateways to
            new adventures! 🚀</p>
    </section>


    <!-- Footer -->
    <!-- <?php include 'footer.php'; ?> -->

</body>

</html>