<?php
session_start();
include 'connection/config.php'; // Database connection

// Handle removing an item from the cart
if (isset($_GET['remove_id'])) {
    $remove_id = intval($_GET['remove_id']);
    if (($key = array_search($remove_id, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the array
        header("Location: cart.php");
        exit();
    }
}

// Handle clearing the cart
if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = [];
    echo "<script>alert('Cart has been cleared!'); window.location.href='cart.php';</script>";
}

// Fetch product details for cart items
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$product_details = [];

if (!empty($cart_items)) {
    $ids = implode(',', array_map('intval', $cart_items)); // Sanitize input
    $sql = "SELECT * FROM books WHERE id IN ($ids)";
    $result = $mysqli->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $product_details[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #6200ea;
            color: #fff;
        }

        .btn {
            background: #6200ea;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .btn:hover {
            background: #3700b3;
        }

        .btn.place-order-btn {
            background: #28a745;
        }

        .btn.place-order-btn:hover {
            background: #218838;
        }

        .btn.remove-btn {
            background: #ff0000;
        }

        .btn.remove-btn:hover {
            background: #e60000;
        }

        .clear-cart-btn {
            background: #ff5722;
        }

        .clear-cart-btn:hover {
            background: #e64a19;
        }

        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Your Cart</h1>

    <!-- Clear Cart Button -->
    <form method="POST" style="display: inline;">
        <button type="submit" name="clear_cart" class="btn clear-cart-btn">Clear Cart</button>
    </form>

    <?php if (empty($product_details)): ?>
        <p>Your cart is empty!</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($product_details as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['title']); ?></td>
                        <td><?php echo htmlspecialchars($product['author']); ?></td>
                        <td>$<?php echo htmlspecialchars($product['price']); ?></td>
                        <td>
                            <!-- Remove Button -->
                            <a href="cart.php?remove_id=<?php echo $product['id']; ?>" class="btn remove-btn">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total">
            Total: $<?php echo array_sum(array_column($product_details, 'price')); ?>
        </div>

        <!-- Place Order Button -->
        <form action="place_order.php" method="POST">
            <button type="submit" class="btn place-order-btn">Place Order</button>
        </form>

        <a href="products.php" class="btn">Continue Shopping</a>
    <?php endif; ?>

    <!-- Continue Shopping Button Always Visible -->
    <a href="products.php" class="btn" style="margin-top: 20px;">Continue Shopping</a>

</div>

</body>
</html>
