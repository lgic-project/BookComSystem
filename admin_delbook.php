<?php


include_once './connection/config.php';
$target_dir = "bookspic/";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    // Use prepared statements to delete by title
    $book_title = $_POST['book_title'];


    //reterive the img path from the database
    $stmt = $mysqli->prepare("SELECT book_img FROM books WHERE title = ?");
    $stmt->bind_param("s", $book_title);
    $stmt->execute();
    $stmt->bind_result($image_url);
    $stmt->fetch();
    $stmt->close();


    if ($image_url) {
        $img_path = $target_dir . $image_url;
        // Delete the img from the folder
        if (file_exists($img_path)) {
            if (unlink($img_path)) {
                header("Location: admin_booklist.php?bookimage=delted");
            }
        }
        // Prepare and bind the statement
        $stmt = $mysqli->prepare("DELETE FROM books WHERE title = ?");
        $stmt->bind_param("s", $book_title);

        // Execute the query
        if ($stmt->execute()) {
            // header("Location: admin_booklist?delete_book=success");
            header("Location: admin_booklist.php");

        } else {
            header("Location: admin_booklist?delete_book=unsuccess");

        }
    }


    // Close the statement
    $stmt->close();
}
?>

















// if (isset($_POST['delbook'])) {
// $title = trim($_POST['title']);
// $sql = "SELECT title from book where title=?";
// if ($stmt = $mysqli->prepare($sql)) {
// $stmt->bind_param("s", $title);
// if ($stmt->execute()) {
// $stmt = $stmt->get_result();
// if ($stmt->num_rows == 1) {
// $rows = $stmt->fetch_assoc();
// if ($title == $rows['title']) {
// $sql = "DELETE FROM book where title=$title";
// $stmt = $mysqli->prepare($sql);
// if($stmt->execute()){
// header("Location: index.php?error = book_delete");
// $stmt->close();
// exit();
// }else{
// header("Location: index.php?error=failed_to_delete_book");
// exit();
// }
// }
// }
// } else {
// header("Location: index.php?error= book_is_not_in_database");
// $stmt->close();
// exit();
// }
// }

// }


?>