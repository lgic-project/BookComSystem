<?php
session_start();
include 'connection/config.php'; // Database connection

// if (isset($_SESSION['transaction_msg'])) {
//     echo $_SESSION['transaction_msg'];
//     unset($_SESSION['transaction_msg']);
// }

// if (isset($_SESSION['validate_msg'])) {
//     echo $_SESSION['validate_msg'];
//     unset($_SESSION['validate_msg']);
// }


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

$place_order = false;
if(!empty($_GET['data'])){
    $place_order= true;
}
if (isset($_GET['data'])) {
    $decoded_data = json_decode(base64_decode($_GET['data']), true);
    if ($decoded_data) {
        $status = $decoded_data['status'] ?? null;
        $user_id = $decoded_data['user_id'] ?? null;
        $amount = $decoded_data['amount'] ?? null;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<?php include 'header.php'; ?>
<div class="wrapper">
    <div class="container">
        <h1>Your Cart</h1>

        <!-- Clear Cart Button -->
        <form method="POST" style="display: inline;">
            <button type="submit" name="clear_cart" class="btn clear-cart-btn">Clear Cart</button>
        </form>

        <?php if (empty($product_details) ): ?>
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

            <!-- Place Order Button -->
            
                <form action="place_order.php" method="post">
                    <input type="hidden" name="total" value="<?php echo $total; ?>">
                    <input type="hidden" name="product_details"
                        value="<?php echo htmlspecialchars(json_encode($product_details)); ?>">
                    <button id="payment-button" type="submit" name="place-order" class="btn place-order-btn">Cash on Delivery</button>
                </form>
                <form action="place_order.php" method="post">
                    <input type="hidden" name="online" value="online">
                    <input type="hidden" name="total" value="<?php echo $total; ?>">
                    <input type="hidden" name="product_details"
                        value="<?php echo htmlspecialchars(json_encode($product_details)); ?>">
                    <button id="payment-button" type="submit" name="place-order" class="btn place-order-btn">Pay With Khalti</button>
                </form>

        <?php endif; ?>

        <!-- Continue Shopping Button Always Visible -->
        <a href="products.php" class="btn" style="margin-top: 20px;">Continue Shopping</a>

    </div>
    <?php include 'footer.php'; ?>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
       var config = {
         
           "publicKey": "live_public_key_2c55477f922e4f60aac6caba3df4addb",
           "productIdentity": "1234567890",
           "productName": "Dragon",
           "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
           "paymentPreference": [
               "KHALTI",
               "EBANKING",
               "MOBILE_BANKING",
               "CONNECT_IPS",
               "SCT",
               ],
           "eventHandler": {
               onSuccess (payload) {
                   console.log(payload);
                   $.ajax({
                       url: "verify.php",
                       type: 'GET',
                       data: {
                           amount: payload.amount,
                           trans_token: payload.token
                       },
                       success: function (res) {
                           console.log(res);
                           
                           if (res.status === 'success') {
                               console.log("Transaction successful");
                           } else {
                               console.log("Transaction failed");
                           }
                       },
                       error: function (error) {
                           console.log("AJAX error:", error);
                       }
                   });

                  Swal.fire({
                    title: "Payment Successful!",
                    text: "Thank you for your payment!",
                    icon: "success"
                    });
               },
               onError (error) {
                   console.log(error);
                
                Swal.fire({
                    title: "Payment Error!",
                    text: "There was an error processing your payment.",
                    icon: "error"
                    });
               },
           }
       };

       var checkout = new KhaltiCheckout(config);
       var btn = document.getElementById("payment-button");
       btn.onclick = function () {
           // minimum transaction amount must be 10, i.e 1000 in paisa.
           checkout.show({amount: <?php echo array_sum(array_column($product_details, 'price')); ?> });
       }
    </script> -->
</body>


</html>