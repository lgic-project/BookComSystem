<?php

if (isset($_GET['amount']) && isset($_GET['trans_token'])) {
    $amount = $_GET['amount'];
    $trans_token = $_GET['trans_token'];

    // Replace 'test_secret_key_abcf34a5e73f49ed8a198a559a8b5d1d' with your actual secret key.
    $secret_key = 'test_secret_key_abcf34a5e73f49ed8a198a559a8b5d1d';

    $url = "https://khalti.com/api/v2/payment/verify/";

    // Prepare data for the Khalti API request.
    $args = [
        'token' => $trans_token,
        'amount' => $amount,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $headers = ['Authorization: Key ' . $secret_key];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Execute the Khalti API request.
    $response = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status_code == 200) {
       
        $decodedResponse = json_decode($response, true);

       
        $decodedResponse['status'] = 'success';

        
        $jsonResponse = json_encode($decodedResponse);

        // Send the JSON response to the client
        header('Content-Type: application/json');
        echo $jsonResponse;
    } else {
        // Send an error JSON response to the client
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Payment Verification Failed']);
    }
} else {
    // Send an invalid request JSON response to the client
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request']);
}

?>