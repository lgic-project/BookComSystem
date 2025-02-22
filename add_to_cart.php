<?php
session_start();

$response = array("success" => false);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    // Initialize the cart if not already done
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add the product ID to the cart
    $_SESSION['cart'][] = $product_id;

    // Set response success
    $response['success'] = true;
    $response['message'] = "Book added to cart successfully!";
}

echo json_encode($response);
exit();
?>
