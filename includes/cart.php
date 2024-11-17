<?php
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="main-content">
        <h1>Your Cart</h1>

        <?php if (empty($cart)) : ?>
            <p>Your cart is empty.</p>
        <?php else : ?>
            <ul>
                <?php foreach ($cart as $item) : ?>
                    <li><?php echo $item['title']; ?> - <?php echo $item['price']; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>
