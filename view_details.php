<?php
include_once 'connection/config.php';

// Start the session
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}

// Check if 'id' is provided via GET and is numeric
if (isset($_GET["id"])) {
    $book_id = intval($_GET["id"]); // Convert to integer for security
    // Fetch book details
    $sql = "SELECT author, title, price , book_description, book_img  FROM books WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        die("<p>No book found with ID <strong>$book_id</strong>.</p>");
    }
    $stmt->close();
} else {
    die("<p>Invalid request.</p>");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['title']); ?></title>
    <link rel="stylesheet" href="./css/products.css">
</head>
<style>
    /* products.css */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
}

.book-details {
    width: 50%;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.book-details img {
    width: 200px;
    height: auto;
    border-radius: 5px;
    margin-bottom: 15px;
}

.book-details h2 {
    font-size: 24px;
    color: #333;
}

.book-details p {
    font-size: 18px;
    color: #666;
}

.book-details strong {
    color: #000;
}

/* Responsive Design */
@media (max-width: 768px) {
    .book-details {
        width: 80%;
    }

    .book-details img {
        width: 150px;
    }
}

</style>
<body>
    <?php include 'header.php'; ?>
    <div class="book-details">
        <img src="bookspic/<?php echo htmlspecialchars($book['book_img']); ?>"
            alt="<?php echo htmlspecialchars($book['title']); ?>">
        <h2><?php echo htmlspecialchars($book['title']); ?></h2>
        <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
        <p><strong>Price:</strong> $<?php echo htmlspecialchars($book['price']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($book['book_description']); ?></p>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>