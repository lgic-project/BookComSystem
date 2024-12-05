<?php
include_once './connection/config.php';

$book_title = htmlspecialchars($_GET['book_title']);

include_once './connection/config.php';

$sql = "SELECT * FROM books WHERE title = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('s', $book_title);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book Details</title>
</head>

<body>
    <h2>Edit Book Details</h2>

    <form action="admin_editbook.php" method="POST">
        <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">

        <label for="title">Book Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>"><br><br>

        <label for="author">Author:</label><br>
        <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>"><br><br>

        <label for="genre">genre:</label><br>
        <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($book['genre']); ?>"><br><br>

        <label for="pub_year">Published year:</label><br>
        <input type="text" id="pub_year" name="pub_year"
            value="<?php echo htmlspecialchars($book['pub_year']); ?>"><br><br>

        <label for="isbn">PUblisher:</label><br>
        <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>"><br><br>

        <label for="publisher">PUblisher:</label><br>
        <input type="text" id="publisher" name="publisher"
            value="<?php echo htmlspecialchars($book['publisher']); ?>"><br><br>


        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($book['price']); ?>"><br><br>

        <label for="stock">stock:</label><br>
        <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($book['stock']); ?>"><br><br>

        <input type="submit" value="Update Book Details">
    </form>
</body>

</html>