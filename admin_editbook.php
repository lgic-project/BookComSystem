<?php
include_once './connection/config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_book'])) {
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $pages = $_POST['pages'];
    $pub_year = $_POST['pub_year'];
    $isbn = $_POST['isbn'];
    $publisher = $_POST['publisher'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $book_description = $_POST['book_description'];
    $stock = $_POST['stock'];

    // Update the book details in the database
    $sql = "UPDATE books SET title = ?, author = ?, genre = ?,pages=?,book_description=?, pub_year = ?,isbn=?, publisher = ?,category = ?, price = ?, stock = ?  WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sssisisssdii', $title, $author, $genre,$pages,$book_description, $pub_year, $isbn, $publisher,$category,  $price, $stock, $book_id);

    if ($stmt->execute()) {

        header("Location: admin_searchbooks.php?bookedit=success");
    } else {
        header("Location: admin_editbooks.php?bookedit = unsuccess");
    }
}

?>