<?php
include_once './connection/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $pages = $_POST['pages'];
    $pub_year = $_POST['pub_year'];
    $isbn = $_POST['isbn'];
    $publisher = $_POST['publisher'];
    $price = $_POST['price'];
    $book_description = $_POST['book_description'];
    $stock = $_POST['stock'];

    // Update the book details in the database
    $sql = "UPDATE books SET title = ?, author = ?, genre = ?, pages = ?, book_description = ?, pub_year = ?, isbn = ?, publisher = ?, price = ?, stock = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sssisissdii', $title, $author, $genre, $pages, $book_description, $pub_year, $isbn, $publisher, $price, $stock, $book_id);

    if ($stmt->execute()) {
        header("Location: admin_searchbooks.php?bookedit=success");
    } else {
        header("Location: admin_editbooks.php?bookedit=unsuccess");
    }
    exit(); // It's good practice to call exit after a header redirection.
}

?>