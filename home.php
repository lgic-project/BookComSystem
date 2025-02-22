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
        /* Banner */
        .banner {
            background: url('bookspic/bg4.jpg') no-repeat center center/cover;
            height: 50vh;
            text-align: center;
            padding: 100px 20px;
            color: white;
        }

        /* Scrollable Row Container */
        .scroll-container {
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            gap: 15px;
            padding: 10px;
            scroll-behavior: smooth;
        }

        /* Hide scrollbar */
        .scroll-container::-webkit-scrollbar {
            display: none;
        }
        .scroll-container {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Book Card */
        .book-card {
            flex: 0 0 auto;
            width: 200px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 15px;
            background: white;
        }

        .book-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 5px;
        }

        .book-card h3 {
            font-size: 16px;
            margin: 10px 0 5px;
        }

        .book-card p {
            font-size: 14px;
            color: #555;
        }

        .book-card .price {
            font-weight: bold;
            color: #000;
            margin-bottom: 10px;
        }

        /* Section Title */
        .book-grid h2 {
            text-align: center;
            margin-bottom: 10px;
            font-size: 22px;
            color: #333;
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
                echo '<p class="price">$' . htmlspecialchars($row['price']) . '</p>';
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
    <h2>About Us</h2>
    <p>E-Book Pasal is your one-stop shop for amazing books. We provide a wide range of collections to satisfy every reader.</p>
</section>

<!-- Footer -->
<?php include 'footer.php'; ?>

</body>
</html>
