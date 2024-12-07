<?php
session_start();
include 'connection/config.php'; // Database connection

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
            margin: 0;
            padding: 0;
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
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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

        .total {
            text-align: right;
            font-size: 1.2rem;
            margin-top: 20px;
        }

        .btn {
            background: #6200ea;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            margin-top: 10px;
        }

        .btn:hover {
            background: #3700b3;
        }

        .place-order-btn {
            background: #28a745;
        }

        .place-order-btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>
        <?php if (empty($product_details)): ?>
            <p>Your cart is empty!</p>
        <?php else: ?>
            <form action="place_order.php" method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>Author</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($product_details as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['title']); ?></td>
                                <td><?php echo htmlspecialchars($product['author']); ?></td>
                                <td>$<?php echo htmlspecialchars($product['price']); ?></td>
                            </tr>
                            <input type="hidden" name="product_ids[]" value="<?php echo $product['id']; ?>">
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="total">
                    Total: $<?php echo array_sum(array_column($product_details, 'price')); ?>
                </div>
                <button type="submit" class="btn place-order-btn">Place Order</button>
            </form>
        <?php endif; ?>
        <a href="products.php" class="btn">Continue Shopping</a>
    </div>
</body>
</html>
