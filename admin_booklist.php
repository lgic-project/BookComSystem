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
    <title>Book Grid</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .grid-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 10px;
        }
        .grid-item img {
            width: 100%;
            height: auto;
        }
        .grid-item h3 {
            font-size: 18px;
            margin: 10px 0;
        }
        .grid-item p {
            font-size: 14px;
            color: #555;
        }
        .grid-item .price {
            font-weight: bold;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="grid-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="grid-item">';
                echo '<img src="./bookspic/' . $row['book_img'] . '" alt="' . $row['title'] . '">';
                echo '<h3>' . $row['title'] . '</h3>';
                echo '<p>by ' . $row['author'] . '</p>';
                echo '<p class="price">$' . $row['price'] . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No books found</p>';
        }
        ?>
    </div>
</body>
</html>
