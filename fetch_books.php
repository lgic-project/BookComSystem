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
                echo "<p><strong>Price:</strong> Rs." . htmlspecialchars($book['price']) . "</p>";
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
            echo "<p><strong>Price:</strong> Rs." . htmlspecialchars($book['price']) . "</p>";
            echo "<a href='view_details.php?id=" . htmlspecialchars($book['id']) . "' class='view-btn'>View Details</a>";
            echo "</div>";
        }
        echo "</div>";
    }
}

$mysqli->close();
?>
<style>
    /* Books Grid Container */
    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        /* Ensures 4 books per row */
        gap: 20px;
        padding: 20px;
        justify-content: center;
    }

    /* Book Card */
    .book-card {
        background: white;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    /* Book Image */
    .book-card img {
        width: 100%;
        height: auto;
        max-height: 250px;
        /* Keeps image size consistent */
        object-fit: cover;
        border-radius: 5px;
        transition: transform 0.3s ease;
    }

    .book-card img:hover {
        transform: scale(1.05);
    }

    /* View Button */
    .view-btn {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 12px;
        background: linear-gradient(135deg, #ff4081, #d81b60);
        color: white;
        text-decoration: none;
        font-weight: bold;
        border-radius: 5px;
        transition: background 0.3s ease, transform 0.3s ease;
    }

    .view-btn:hover {
        background: linear-gradient(135deg, #d81b60, #b0003a);
        transform: translateY(-2px);
    }

    /* Responsive for smaller screens */
    @media (max-width: 1024px) {
        .books-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            /* 2-3 books per row on medium screens */
        }
    }

    @media (max-width: 768px) {
        .books-grid {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            /* 2 books per row */
        }
    }

    @media (max-width: 480px) {
        .books-grid {
            grid-template-columns: repeat(auto-fill, minmax(100%, 1fr));
            /* 1 book per row on small screens */
        }
    }
</style>