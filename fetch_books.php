<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'connection/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['genre'])) {
    $genre = trim($_POST['genre']);

    if (empty($genre)) {
        die("<p>No genre selected.</p>");
    }

    $sql = "SELECT * FROM books WHERE genre = ?";
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param("s", $genre);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        die("Error executing query: " . $stmt->error);
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='product-card'>";
            echo "<img src='bookspic/" . htmlspecialchars($row['book_img']) . "' alt='" . htmlspecialchars($row['title']) . "'>";
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p>Author: " . htmlspecialchars($row['author']) . "</p>";
            echo "<p>Price: $" . htmlspecialchars($row['price']) . "</p>";
            echo "<div class='buttons'>";
            echo "<form action='view_details.php' method='GET' style='display: inline;'>";
            echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
            echo "<button type='submit'>View Details</button>";
            echo "</form>";
            echo "<button class='add-to-cart-btn' data-id='" . $row['id'] . "'>Add to Cart</button>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No books available in this category.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Invalid request.</p>";
}

$mysqli->close();
?>
