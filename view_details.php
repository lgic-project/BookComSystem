<?php
include_once 'connection/config.php';

// Check if 'id' is provided via GET and is numeric
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $book_id = intval($_GET["id"]); // Convert to integer for security

    // Fetch book details
    $sql = "SELECT * FROM books WHERE id = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
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
        die("<p>Database error: " . $mysqli->error . "</p>");
    }
} else {
    die("<p>Invalid request.</p>");
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['title']); ?></title>
    <link rel="stylesheet" href="./css/products.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="book-details">
        <img src="bookspic/<?php echo htmlspecialchars($book['book_img']); ?>"
            alt="<?php echo htmlspecialchars($book['title']); ?>">
        <h2><?php echo htmlspecialchars($book['title']); ?></h2>
        <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
        <p><strong>Price:</strong> $<?php echo htmlspecialchars($book['price']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($book['description']); ?></p>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>