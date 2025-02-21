<?php
session_start();
include 'connection/config.php';
$_SESSION['user_id'] = 1;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location:cart.php?status=login_to_place_order_");
        exit;
    }
    $payment_method = '';
    if ($_POST['online'] == 'online') {
        $payment_method = 'Online';
    }

    //fetch book quantity from the database
    // if($result = $mysqli->query("SELECT stock AS book_quantity FROM books where id = $")){
    //     if($result){
    //         $row = $result->fetch_assoc();
    //         $book_quantity = $row['book_quantity'];

    //         if($book_quantity <= 0 ){
    //             header("Location: place_order?error=out_of_stock");
    //             exit();
    //         }
    //     }
    //     $result->close();
    // }


    $product_details = json_decode($_POST['product_details'], true);





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


            $user_id = 1;
            $order_date = date("Y-m-d H:i:s");
            $status = 'Pending';


            if ($user_id) {
                // Fetch User Address & Phone
                $stmt = $mysqli->prepare("SELECT username,address, phone_no FROM users WHERE id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $user_result = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                if ($user_result) {
                    $user_address = $user_result['address'];
                    $user_phone = $user_result['phone_no'];

                    // Insert Order with Address & Phone
                    $stmt = $mysqli->prepare("INSERT INTO orders (user_id, order_date, total_price, status, address, phone_no) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("isssss", $user_id, $order_date, $total_price, $status, $user_address, $user_phone);
                    if ($stmt->execute()) {
                        $order_id = $stmt->insert_id;

                        // Insert Each Product into Order Items Table
                        $stmt = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");

                        foreach ($product_details as $product) {
                            $product_id = $product['id'];
                            $quantity = 1;
                            $price = $product['price'];
                            if($quantity >1 ){
                                $price = $price * $quantity;
                            }
                            $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
                            $stmt->execute();
                        }

                        unset($_SESSION['cart']);
                        $data = base64_encode(json_encode(["status" => "order_placed", "order_id" => "$order_id", "user_id" => $user_id, "amount" => $total_price, "order_date" => $order_date]));
                        if (!empty($payment_method)) {
                            header("Location: payment-request.php?data=$data");
                        } else {
                            header("Location: cart.php?status=order_placed");
                        }
                    } else {
                        echo "Failed to place order: " . $mysqli->error;
                    }
                    $stmt->close();
                }
            }

        }
    } else {
        echo "<script>alert('Your cart is empty!'); window.location.href = 'cart.php';</script>";
    }
}
?>