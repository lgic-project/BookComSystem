<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'connection/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["genre"]) && !empty(trim($_POST["genre"]))) {
        $genre = trim($_POST["genre"]);

        $sql = "SELECT * FROM books WHERE genre = ?";
        $stmt = $mysqli->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $mysqli->error);
        }

        $stmt->bind_param("s", $genre);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h2 style='color: #6200ea;'>$genre</h2>";
        echo "<div class='books-grid'>";
        if ($result->num_rows > 0) {
            while ($book = $result->fetch_assoc()) {
                echo "<div class='book-card'>";
                echo "<img src='bookspic/" . htmlspecialchars($book['book_img']) . "' alt='" . htmlspecialchars($book['title']) . "'>";
                echo "<h3>" . htmlspecialchars($book['title']) . "</h3>";
                echo "<p><strong>Author:</strong> " . htmlspecialchars($book['author']) . "</p>";
                echo "<p><strong>Price:</strong> $" . htmlspecialchars($book['price']) . "</p>";
                echo "<a href='view_details.php?id=" . htmlspecialchars($book['id']) . "' class='view-btn'>View Details</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No books found for <strong>" . htmlspecialchars($genre) . "</strong>.</p>";
        }
        echo "</div>";

        $stmt->close();
    } else {
        $sql = "SELECT * FROM books";
        $result = $mysqli->query($sql);

        echo "<div class='books-grid'>";
        while ($book = $result->fetch_assoc()) {
            echo "<div class='book-card'>";
            echo "<img src='bookspic/" . htmlspecialchars($book['book_img']) . "' alt='" . htmlspecialchars($book['title']) . "'>";
            echo "<h3>" . htmlspecialchars($book['title']) . "</h3>";
            echo "<p><strong>Author:</strong> " . htmlspecialchars($book['author']) . "</p>";
            echo "<p><strong>Price:</strong> $" . htmlspecialchars($book['price']) . "</p>";
            echo "<a href='view_details.php?id=" . htmlspecialchars($book['id']) . "' class='view-btn'>View Details</a>";
            echo "</div>";
        }
        echo "</div>";
    }
}

$mysqli->close();
?>
