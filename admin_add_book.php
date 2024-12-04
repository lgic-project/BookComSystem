<?php
// if (!isset($_SESSION['username']) && !$_SESSION['login_success']) {
//     header(" Location: login.php");
//     exit();
// }

include './connection/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_FILES["book_image"]["error"] === UPLOAD_ERR_OK) {
    
    $title = trim($_POST['title']);
    $auther = trim($_POST['author']);
    $genre = trim($_POST['genre']);
    $pub_year = trim($_POST['pub_year']);
    $isbn = $_POST['isbn'];
    $publisher = trim($_POST['publisher']);
    $price = trim($_POST['price']);
    $stock = $_POST['stock'];
    $bookfile_name = basename($_FILES["book_image"]["name"]);

    if (!file_exists('bookspic')) {
        mkdir('bookspic', 0777, true);
    }

    $target_dir = "bookspic/";
    $file_extension = strtolower(pathinfo($bookfile_name, PATHINFO_EXTENSION));
    $new_book_img = uniqid() . '.' . $file_extension; // Generate unique filename
    $target_file = $target_dir . $new_book_img;

    // Check if image file is actual image
    $check = getimagesize($_FILES["book_image"]["tmp_name"]);
    if ($check === false) {
        header("Location: dashboard.php?upload=error");
        exit();
    }

    // Allow certain file formats
    if ($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif") {
        header("Location: dashboard.php?upload=error");
        exit();
    }



    $sql = "SELECT id from books where title=?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $title);
        if ($stmt->execute()) {
            if ($stmt->num_rows > 0) {
                header("Location: index.php?error=books_already_in_store");
                exit();
            }
        }
    }
    $stmt;
    //inserting book in the database
    //first we need to uplaod file
    if (move_uploaded_file($_FILES["book_image"]["tmp_name"], $target_file)) {
        $sql = "INSERT  INTO books (title, author, genre, pub_year, isbn, publisher, price, stock, book_img ) VAlUES (?, ?, ?, ?, ?, ?, ?, ?,?)";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("sssissdis",$title, $auther, $genre, $pub_year, $isbn, $publisher, $price, $stock, $new_book_img);
            if ($stmt->execute()) {
                $stmt->store_result();
                header("Location: admin_add_book.php?add_book=success");
                $stmt->close();
                exit();
            } else {
                header("Location: admin_add_book.php?add_book= Book_add_fail");
                $stmt->close();
                exit();
            }
        }
    }else{

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Entry Form</title>
</head>
<body>
    <h1>Enter Book Details</h1>
    <form action="admin_add_book.php" method="POST" enctype="multipart/form-data">
        <!-- Title -->
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br><br>

        <!-- Author -->
        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required>
        <br><br>

        <!-- Genre -->
        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre">
        <br><br>

        <!-- Publication Year -->
        <label for="pub_year">Publication Year:</label>
        <input type="number" id="pub_year" name="pub_year" min="1000" max="9999">
        <br><br>

        <!-- ISBN -->
        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" required>
        <br><br>

        <!-- Publisher -->
        <label for="publisher">Publisher:</label>
        <input type="text" id="publisher" name="publisher">
        <br><br>

        <!-- Price -->
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" min="0">
        <br><br>

        <!-- Stock -->
        <label for="stock">Stock Quantity:</label>
        <input type="number" id="stock" name="stock" min="0" step="1">
        <br><br>

        <!-- Image -->
        <label for="img">Book Cover Image:</label>
        <input type="file"  name="book_image" id="book_image" accept="bookspic/" required >
        <br><br>

        <!-- Submit Button -->
        <button type="submit">Add Book</button>
    </form>
</body>
</html>
