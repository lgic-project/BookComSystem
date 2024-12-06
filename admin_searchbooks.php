<?php

include('./connection/config.php');

if(isset($_GET['bookedit'])){
    if($_GET['bookedit'] === 'success'){
    echo "<h5>Book edit success <h5>";
    }
}

$search_results = [];
$search_query = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    $search_query = $_GET['search'];

    // Search the database for books matching the title or author
    $sql = "SELECT * FROM books WHERE title LIKE ? OR author LIKE ?";
    $stmt = $mysqli->prepare($sql);
    $search_term = "%" . $search_query . "%"; // For partial matching
    $stmt->bind_param('ss', $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the results into an array
    while ($row = $result->fetch_assoc()) {
        $search_results[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
</head>
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
        margin: 15px 15px;
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

    .edit-button{
        padding: 4px;
        border: 2px solid red;
    }
</style>

<body>
    <h2>Search Books</h2>

    <!-- Search Form -->
    <form action="admin_searchbooks.php" method="GET">
        <label for="search">Search by Title or Author:</label>
        <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search_query); ?>" required>
        <input type="submit" value="Search">
    </form>

    <!-- Display Results -->
    
        <?php
        if (!empty($search_results)): ?>
            <h3>Search Results:</h3>
            <div class="grid-container">
            <?php
            foreach ($search_results as $row){
                echo '<div class="grid-item">';
                echo '<img src="./bookspic/' . $row['book_img'] . '" alt="' . htmlspecialchars($row['title']) . '">';
                echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                echo '<p>by ' . htmlspecialchars($row['author']) . '</p>';
                echo '<p class="price">$' . htmlspecialchars($row['price']) . '</p>';
                echo "<p><a  class='edit-button' href='admin_editbooks.php?book_title=" . $row['title']."' >Edit</a></p>";
                echo '</div>';
            }
            ?>
             </div>
          <?php elseif (!empty($search_query)): ?>
        <p>No results found for "<?php echo htmlspecialchars($search_query); ?>".</p>
    <?php endif; ?>
   
</body>

</html>