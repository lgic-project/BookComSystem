<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'light-mode';
}

include 'header.php';
include 'connection/config.php';

// Fetch unique genres
$sqlGenres = "SELECT DISTINCT genre FROM books";
$resultGenres = $mysqli->query($sqlGenres);
if (!$resultGenres) {
    die("Error fetching genres: " . $mysqli->error);
}
?>

<div style="display: flex; gap: 10px; margin-bottom: 20px; overflow-x: auto;">
    <?php while ($row = $resultGenres->fetch_assoc()) : ?>
        <button class="genre-btn" onclick="fetchBooks('<?php echo htmlspecialchars($row['genre']); ?>')">
            <?php echo htmlspecialchars($row['genre']); ?>
        </button>
    <?php endwhile; ?>
</div>

<!-- Default book list -->
<div id="books-container">
    <p>Loading books...</p>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetchBooks(); // Load all books initially
});

function fetchBooks(genre = '') {
    document.getElementById("books-container").innerHTML = "<p>Loading books...</p>";
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "fetch_books.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
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
    white-space: nowrap;
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
