<?php
// Start the session to track user information (like cart contents)
session_start();

// Example: Check if there are items in the cart
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>
    <link rel="stylesheet" href="assets/css/styles.css">

</head>
<body>
    
</body>
</html>
