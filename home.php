<?php
require_once './connection/config.php';


$user_id = 1;
if (isset($_POST['add_to_cart'])) {

    $book_id = $_POST['book_id'];
    $book_title = $_POST['book_title'];
    $book_price = $_POST['book_price'];
    $book_quantity = $_POST['quantity'];

    //book quantity section where book quantity condition applied later code on 


    $check_cart_numbers = $mysqli->query("SELECT * FROM `cart` WHERE user_id = '$user_id' AND product_id= '$book_id'");
    if ($check_cart_numbers->num_rows > 0) {
        header("Location:home.php?msg=already_in_cart");
    } else {
        if ($mysqli->query("INSERT INTO `cart`(user_id, product_id, quantity, amount) VALUES('$user_id', '$book_id','$book_quantity', '$book_price')")) {
            header("Location:home.php?msg=book_inserted_in_cart");

        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Commercial Site</title>
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    <section class="banner">
        <h1>Welcome to E Book Pasal</h1>
        <p>Discover your next great read!</p>
    </section>

    <section class="book-grid">
        <h2>Featured Books</h2>
        <div class="grid-container">
            <?php
            $sql = "SELECT id, title, author, price, book_img  FROM books";
            $result = $mysqli->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="grid-item">
                        <img src="bookspic/<?php echo $row['book_img']; ?>" alt="<?php htmlspecialchars($row['title']); ?>">
                        <h3> <?php echo htmlspecialchars($row['title']) ?> </h3>
                        <p> by <?php echo htmlspecialchars($row['author']) ?></p>
                        <p class="price">$<?php echo htmlspecialchars($row['price']) ?> </p>

                        <form action="" Method="POST">
                            <input type="hidden" name="book_image" value="<?php echo $row['book_img']; ?>">
                            <input type="hidden" name="book_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="book_title" value=" <?php echo $row['title']; ?>">
                            <input type="hidden" name="book_price" value="<?php echo $row['price']; ?>">
                            <input type="number" name="quantity" value="1" min="1" required>
                            <button type="submit" name="add_to_cart">Add to Cart</button>
                        </form>
                    </div>
                    <?php
                }
            } else {
                echo '<p>No books found</p>';
            }
            ?>

        </div>
    </section>

    <section class="about">
        <h2>About Us</h2>
        <p>E Book Pasal is your one-stop shop for amazing books. We provide a wide range of collections to satisfy every
            reader.</p>
    </section>

    <script>
        function toggleTheme() {
            document.body.classList.toggle('light-mode');
            document.body.classList.toggle('dark-mode');
        }
    </script>
</body>

</html>