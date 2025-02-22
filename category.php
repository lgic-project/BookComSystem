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

if (isset($_GET['category'])) {
    $category = $_GET['category'];
} else {
    $category = 'all';
}


include 'header.php';
include 'connection/config.php';


if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $searchTerm = "%{$category}%";  // Store it in a separate variable

    $sql = "SELECT * FROM books WHERE genre LIKE ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $searchTerm);  // Pass the variable instead of "%$category%"
    $stmt->execute();
    $resultGenres = $stmt->get_result();

} else {
    // Fetch unique genres
    $sqlGenres = "SELECT DISTINCT genre FROM books";
    $resultGenres = $mysqli->query($sqlGenres);
    if (!$resultGenres) {
        die("Error fetching genres: " . $mysqli->error);
    }
}
?>

<!-- Genre Buttons -->
<div class="genre-container">
    <button class="genre-btn" onclick="fetchBooks()">All</button>
    <?php while ($row = $resultGenres->fetch_assoc()): ?>
        <button class="genre-btn" onclick="fetchBooks('<?php echo htmlspecialchars($row['genre']); ?>')">
            <?php echo htmlspecialchars($row['genre']); ?>
        </button>
    <?php endwhile; ?>
</div>

<!-- Books Display Container -->
<div id="books-container">
    <p>Loading books...</p>
</div>

<?php include 'footer.php'; ?>


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
    /* Genre Button Styling */
    .genre-container {
        display: flex;
        gap: 10px;
        margin: 20px 0;
        overflow-x: auto;
        padding: 10px;
    }

    .genre-btn {
        padding: 12px 18px;
        background: linear-gradient(135deg, #6200ea, #7b1fa2);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        white-space: nowrap;
        font-weight: bold;
        font-size: 14px;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    }

    .genre-btn:hover {
        background: linear-gradient(135deg, #3700b3, #4a148c);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    /* Books Container - Horizontal Scroll */
    #books-container {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 15px;
        padding: 10px;
        margin-top: 30px;
        scroll-behavior: smooth;
    }

    #books-container::-webkit-scrollbar {
        height: 8px;
    }

    #books-container::-webkit-scrollbar-thumb {
        background-color: #6200ea;
        border-radius: 10px;
    }

    #books-container::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Book Card Styling */
    .book-card {
        border: 1px solid #ddd;
        padding: 15px;
        min-width: 220px;
        text-align: center;
        border-radius: 10px;
        background: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    /* Book Image Styling */
    .book-card img {
        width: 120px;
        height: 180px;
        object-fit: cover;
        border-radius: 5px;
        transition: transform 0.3s ease;
    }

    .book-card img:hover {
        transform: scale(1.05);
    }

    /* View Button Styling */
    .view-btn {
        display: block;
        margin-top: 12px;
        background: linear-gradient(135deg, #ff4081, #d81b60);
        color: white;
        padding: 8px 12px;
        font-weight: bold;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    }

    .view-btn:hover {
        background: linear-gradient(135deg, #d81b60, #b0003a);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }
</style>