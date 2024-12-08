<?php
session_start();
include 'connection/config.php';
$_SESSION['user_id'] = 1;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location:place_order.php?status=login_to_place_order_");
        exit;
    }

    if (!empty($_SESSION['cart'])) {
        $cart_items = $_SESSION['cart'];
        $ids = implode(',', array_map('intval', $cart_items));

        // Fetch products from the database
        $sql = "SELECT * FROM books WHERE id IN ($ids)";
        $result = $mysqli->query($sql);

        if ($result) {
            $total_price = 0;

            while ($row = $result->fetch_assoc()) {
                $total_price += $row['price'];
            }

            $user_id = $_SESSION['user_id'];
            $order_date = date("Y-m-d H:i:s");
            $status = 'Pending';

            // Insert order into database
            $stmt = $mysqli->prepare("INSERT INTO orders (user_id, order_date, total_price, status) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("issd", $user_id, $order_date, $total_price, $status);

            if ($stmt->execute()) {
                unset($_SESSION['cart']);
                echo "<script>alert('Order placed successfully!'); window.location.href = 'products.php';</script>";
            } else {
                echo "Failed to place order: " . $mysqli->error;
            }
            $stmt->close();
        }
    } else {
        echo "<script>alert('Your cart is empty!'); window.location.href = 'cart.php';</script>";
    }
}
?>
