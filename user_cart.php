<?php
$user_id = 1;
include_once './connection/config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<section class="book-grid">
        <h2>Featured Books</h2>
        <div class="grid-container">
            <?php
            $grand_total = 0;
            $cart = $mysqli->query("SELECT * FROM `cart` WHERE user_id = '$user_id'");
            if ($cart->num_rows > 0) {
                while ($row = $cart->fetch_assoc()) {
                    $book_details = $mysqli->query("SELECT title,author,price, stock, book_img FROM books WHERE id='$row[product_id]'");
                    if($book_details->num_rows>0){
                        $book_row = $book_details->fetch_assoc();
                    }
                    ?>
                    <div class="grid-item">
                    <img src="bookspic/<?php echo $book_row['book_img']; ?>" alt="<?php htmlspecialchars($book_row['title']); ?>" >
                    <h3> <?php echo htmlspecialchars($book_row['title']) ?> </h3>
                    <p> by <?php echo htmlspecialchars($book_row['author']) ?></p>
                    <p class="price">$<?php echo htmlspecialchars($book_row['price']) ?> </p>
                   
                    <form action="" Method="POST">
                    <!-- <input type="hidden" name="book_id" value="<?php echo $book_row['id']; ?>">
                    <input type="hidden" name="book_price" value="<?php echo $book_row['price']; ?>"> -->
                    <input type="number" name="quantity" value="1" min="1" required>
                    <button type="submit">Add</button>
                    </form>
                    <div class="sub_total">Total: <span>$<?php echo $sub_total= $book_row['price'] * $row['quantity'] ?> </span></div>
                    </div>
                    <?php
                    $grand_total+= $sub_total;
                }

            } else {
                echo '<p>No books found</p>';
            }
            ?>

        </div>
    </section>
</body>
</html>