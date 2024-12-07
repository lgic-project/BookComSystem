<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    // Initialize the cart if not already done
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add the product ID to the cart
    $_SESSION['cart'][] = $product_id;

    // Return success message
    echo json_encode(['message' => 'Added to cart']);
}
?>
