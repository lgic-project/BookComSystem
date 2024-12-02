<?php
if (!isset($_SESSION['username']) && !$_SESSION['login_success']) {
    header(" Location: login.php");
    exit();
}

include_once './connection/config.php';

if (isset($_POST['addbook'])) {
    $title = trim($_POST['title']);
    $auther = trim($_POST['author']);
    $genre = trim($_POST['genre']);
    $pub_year = trim($_POST['pub_year']);
    $isbn = $_POST['isbn'];
    $publisher = mysqli_real_escape_string($conn, trim($_POST['publisher']));
    $price = trim($_POST['price']);
    $stock = $_POST['stock'];



    $sql = "SELECT id from book where title=?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $title);
        if ($stmt->execute()) {
            if ($stmt->num_rows > 0) {
                header("Location: index.php?error=books_already_in_store");
                exit();
            }
        }
    }

    //inserting book in the database
    $sql = "INSERT into books (title, author, genre, pub_year, isbn, publisher, price, stock ) VAlUES (?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sssissdi", $title, $author, $genre, $publication_year, $isbn, $publisher, $price, $stock);
        if ($stmt->execute()) {
            $stmt->store_result();
            header("Location: index.php?add_book=success");
            $stmt->close();
            exit();
        } else {
            header("Location: index.php?add_book= Book_add_fail");
            $stmt->close();
            exit();
        }
    }

}

?>