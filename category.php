<?php
<<<<<<< HEAD
// Include database connection
include_once 'connection/config.php';

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}
=======
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'connection/config.php';
>>>>>>> d054452b2e85197f12a2794f4450481f65be6fbd

// Fetch unique genres
$sqlGenres = "SELECT DISTINCT genre FROM books";
$resultGenres = $mysqli->query($sqlGenres);
<<<<<<< HEAD
=======

>>>>>>> d054452b2e85197f12a2794f4450481f65be6fbd
if (!$resultGenres) {
    die("Error fetching genres: " . $mysqli->error);
}

<<<<<<< HEAD
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link rel="stylesheet" href="./css/products.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <style>
        /* Genre Buttons */
        .genre-container {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

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

        /* Product Grid */
        .products-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .product-card {
            border: 1px solid #ddd;
            padding: 10px;
            width: 200px;
            text-align: center;
        }

        .product-card img {
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
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Our Books</h1>

        <!-- Genre Buttons -->
        <div class="genre-container">
            <?php while ($row = $resultGenres->fetch_assoc()): ?>
                <button class="genre-btn" onclick="fetchBooks('<?php echo htmlspecialchars($row['genre']); ?>')">
                    <?php echo htmlspecialchars($row['genre']); ?>
                </button>
            <?php endwhile; ?>
        </div>

        <!-- Books Grid -->
        <div class="products-grid" id="books-container">
            <!-- Books will be loaded here dynamically -->
        </div>
    </div>

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

    <?php include 'footer.php'; ?>
</body>
</html>
=======
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
