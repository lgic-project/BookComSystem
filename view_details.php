<?php
include_once 'connection/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["genre"])) {
    $genre = trim($_POST["genre"]);

    // Fetch books based on genre
    $sql = "SELECT * FROM books WHERE genre = ?";
    $stmt = $mysqli->prepare($sql);
    
    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param("s", $genre);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>$genre</h2><div class='products-grid'>";
        while ($book = $result->fetch_assoc()) {
            echo '<div class="product-card">';
            echo '<img src="bookspic/' . htmlspecialchars($book['book_img']) . '" alt="' . htmlspecialchars($book['title']) . '">';
            echo '<h3>' . htmlspecialchars($book['title']) . '</h3>';
            echo '<p>Author: ' . htmlspecialchars($book['author']) . '</p>';
            echo '<p>Price: $' . htmlspecialchars($book['price']) . '</p>';
            echo '<a href="view_details.php?id=' . htmlspecialchars($book['id']) . '" class="view-btn">View Details</a>';
            echo '</div>';
        }
        echo "</div>";
    } else {
        echo "<p>No books found for <strong>$genre</strong>.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Invalid request.</p>";
}

$mysqli->close();
?>
