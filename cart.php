<?php
session_start();
include 'connection/config.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id']; // Fetch user ID from session

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

// Fetch pending orders for the logged-in user
$pending_orders = [];
$order_query = "SELECT * FROM orders WHERE user_id = ? AND status = 'Pending'";
$stmt = $mysqli->prepare($order_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $pending_orders[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cart.css">
    <style>
        .container{
            width: 700px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="wrapper">
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
                                <td>Rs.<?php echo htmlspecialchars($product['price']); ?></td>
                                <td>
                                    <!-- Remove Button -->
                                    <a href="cart.php?remove_id=<?php echo $product['id']; ?>" class="btn remove-btn">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="total">
                    Total: Rs.<?php echo array_sum(array_column($product_details, 'price')); ?>
                    <?php $total = array_sum(array_column($product_details, 'price')); ?>
                </div>

                <!-- Place Order Buttons -->
                <form action="place_order.php" method="post">
                    <input type="hidden" name="total" value="<?php echo $total; ?>">
                    <input type="hidden" name="product_details"
                        value="<?php echo htmlspecialchars(json_encode($product_details)); ?>">
                    <button type="submit" name="place-order" class="btn place-order-btn">Cash on Delivery</button>
                </form>

                <form action="place_order.php" method="post">
                    <input type="hidden" name="online" value="online">
                    <input type="hidden" name="total" value="<?php echo $total; ?>">
                    <input type="hidden" name="product_details"
                        value="<?php echo htmlspecialchars(json_encode($product_details)); ?>">
                    <button type="submit" name="place-order" class="btn place-order-btn">Pay With Khalti</button>
                </form>
            <?php endif; ?>

            <!-- Pending Orders Section -->
            <h2>Pending Orders</h2>
            <?php if (empty($pending_orders)): ?>
                <p>No pending orders.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Total Price</th>
                            <th>Address</th>
                            <th>Phone No</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending_orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['id']); ?></td>
                                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                <td>Rs.<?php echo htmlspecialchars($order['total_price']); ?></td>
                                <td><?php echo htmlspecialchars($order['address']); ?></td>
                                <td><?php echo htmlspecialchars($order['phone_no']); ?></td>
                                <td><?php echo htmlspecialchars($order['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <!-- Continue Shopping Button -->
            <a href="products.php" class="btn" style="margin-top: 20px;">Continue Shopping</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>

</html>