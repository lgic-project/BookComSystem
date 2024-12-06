<?php
require_once './connection/config.php';


$sql = "SELECT id, title, author, price, book_img  FROM books";
$result = $mysqli->query($sql);



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Commercial Site</title>
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    <section class="banner">
        <h1>Welcome to E Book Pasal</h1>
        <p>Discover your next great read!</p>
    </section>

    <section class="book-grid">
        <h2>Featured Books</h2>
        <div class="grid-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="grid-item">';
                    echo '<img src="./bookspic/' . $row['book_img'] . '" alt="' . htmlspecialchars($row['title']) . '">';
                    echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                    echo '<p>by ' . htmlspecialchars($row['author']) . '</p>';
                    echo '<p class="price">$' . htmlspecialchars($row['price']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No books found</p>';
            }
            ?>

        </div>
    </section>

    <section class="about">
        <h2>About Us</h2>
        <p>E Book Pasal is your one-stop shop for amazing books. We provide a wide range of collections to satisfy every
            reader.</p>
    </section>

<script>
function toggleTheme() {
            document.body.classList.toggle('light-mode');
            document.body.classList.toggle('dark-mode');
        }
</script>
</body>

</html>