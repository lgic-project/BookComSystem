<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'connection/config.php';

<<<<<<< HEAD
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
=======
// Fetch unique genres
$sqlGenres = "SELECT DISTINCT genre FROM books";
$resultGenres = $mysqli->query($sqlGenres);

if (!$resultGenres) {
    die("Error fetching genres: " . $mysqli->error);
}

echo "<div style='display: flex; gap: 10px; margin-bottom: 20px;'>";

while ($row = $resultGenres->fetch_assoc()) {
    echo "<button class='genre-btn' onclick=\"fetchBooks('" . htmlspecialchars($row['genre']) . "')\">" . htmlspecialchars($row['genre']) . "</button>";
}

echo "</div>";

// Fetch books dynamically based on genre
echo "<div id='books-container'></div>";

?>

<script>
function fetchBooks(genre) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "fetch_books.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("books-container").innerHTML = xhr.responseText;
        }
    };
    xhr.send("genre=" + encodeURIComponent(genre));
}
</script>

<style>
.genre-btn {
    padding: 10px 15px;
    background-color: #6200ea;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.genre-btn:hover {
    background-color: #3700b3;
}
.book-card {
    border: 1px solid #ddd;
    padding: 10px;
    margin: 10px 0;
    width: 200px;
    text-align: center;
}
.book-card img {
    width: 100px;
    height: 150px;
    object-fit: cover;
}
.view-btn {
    display: block;
    margin-top: 10px;
    background: #ff4081;
    color: white;
    padding: 5px;
    text-decoration: none;
    border-radius: 3px;
}
.view-btn:hover {
    background: #d81b60;
}
</style>
>>>>>>> d054452b2e85197f12a2794f4450481f65be6fbd
