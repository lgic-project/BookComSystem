<?php
include './connection/config.php';
session_start();
if (isset($_GET['data'])) {
    $decoded_data = json_decode(base64_decode($_GET['data']), true);
    if ($decoded_data) {
        $status = $decoded_data['status'] ?? null;
        $user_id = $decoded_data['user_id'] ?? null;
        $purchase_order_id = $decoded_data['order_id'] ?? null;
        $amount = $decoded_data['amount'] * 100 ?? null;
    }
    if ($user_id && $purchase_order_id) {
        // Fetch User Info (Including Address and Phone Number)
        $stmt = $mysqli->prepare("SELECT username, email, phone_no FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user_result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        // Fetch Order Info
        $stmt = $mysqli->prepare("SELECT total_price, address, phone_no FROM orders WHERE id = ?");
        $stmt->bind_param("i", $purchase_order_id);
        $stmt->execute();
        $order_result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }
    $name = $user_result['username'];
    $email = $user_result['email'];
    $phone = $user_result['phone_no'];

    //here validate the data
    // if (empty($amount) || empty($purchase_order_id)  || empty($name) || empty($email) || empty($phone)) {
    //     $_SESSION["validate_msg"] = '<script>
    //     Swal.fire({
    //         icon: "error",
    //         title: "All fields are required",
    //         showConfirmButton: false,
    //         timer: 1500
    //     });
    // </script>';
    //     header("Location: cart.php");
    //     exit();
    // }
    // //check if the amount is a number
    // if (!is_numeric($amount)) {
    //     $_SESSION["validate_msg"] = '<script>
    //     Swal.fire({
    //         icon: "error",
    //         title: "Amount must be a number",
    //         showConfirmButton: false,
    //         timer: 1500
    //     });
    // </script>';
    //     header("Location: cart.php");
    //     exit();
    // }

    // //check if the phone number is a number
    // if (!is_numeric($phone)) {
    //     $_SESSION["validate_msg"] = '<script>
    //     Swal.fire({
    //         icon: "error",
    //         title: "Phone must be a number",
    //         showConfirmButton: false,
    //         timer: 1500
    //     });
    // </script>';
    //     header("Location: cart.php");
    //     exit();
    // }

    // //check if the email is valid
    // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //     $_SESSION["validate_msg"] = '<script>
    //     Swal.fire({
    //         icon: "error",
    //         title: "Email is not valid",
    //         showConfirmButton: false,
    //         timer: 1500
    //     });
    // </script>';
    //     header("Location: cart.php");
    //     exit();
    // }

    $postFields = array(
        "return_url" => "http://localhost/BookComSystem/payment-response.php",
        "website_url" => "http://localhost/BookComSystem/",
        "amount" => $amount,
        "purchase_order_id" => $purchase_order_id,
        "purchase_order_name" => $name,
        "customer_info" => array(
            "name" => $name,
            "email" => $email,
            "phone" => $phone,
        )
    );

}
$jsonData = json_encode($postFields);

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $jsonData,
    CURLOPT_HTTPHEADER => array(
        'Authorization: key live_secret_key_68791341fdd94846a146f0457ff7b455',
        'Content-Type: application/json',
    ),
));

$response = curl_exec($curl);


if (curl_errno($curl)) {
    echo 'Error:' . curl_error($curl);
} else {
    $responseArray = json_decode($response, true);

    if (isset($responseArray['error'])) {
        echo 'Error: ' . $responseArray['error'];
    } elseif (isset($responseArray['payment_url'])) {
        // Redirect the user to the payment page
        header('Location: ' . $responseArray['payment_url']);
    } else {
        echo 'Unexpected response: ' . $response;
    }
}

curl_close($curl);