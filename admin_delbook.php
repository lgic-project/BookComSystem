<?php


include_once './connection/config.php';

if (isset($_POST['delbook'])) {
    $title = trim($_POST['title']);


    //checking the book is in the database or not 
    $sql = "SELECT title from book where title=?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $title);
        if ($stmt->execute()) {
            $stmt = $stmt->get_result();
            if ($stmt->num_rows == 1) {
                $rows = $stmt->fetch_assoc();
                if ($title == $rows['title']) {
                    $sql = "DELETE FROM book where title=$title";
                    $stmt = $mysqli->prepare($sql);
                    if($stmt->execute()){
                        header("Location: index.php?error = book_delete");
                        $stmt->close();
                        exit();
                    }else{
                        header("Location: index.php?error=failed_to_delete_book");
                        exit();
                    }
                }
            }
        } else {
            header("Location: index.php?error= book_is_not_in_database");
            $stmt->close();
            exit();
        }
    }

}
?>