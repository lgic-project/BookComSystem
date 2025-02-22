<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment successful</title>
</head>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
        margin: 0;
    }

    .container {
        text-align: center;
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .checkmark {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #4CAF50;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto 20px;
    }

    .checkmark::after {
        content: '✔';
        font-size: 40px;
        color: white;
        font-weight: bold;
    }

    h2 {
        color: #333;
        margin-bottom: 10px;
    }

    p {
        color: #666;
        font-size: 16px;
    }

    .redirect-message {
        font-size: 14px;
        margin-top: 15px;
        color: #888;
    }
</style>
</style>

<body>
    <?php
    session_start();
    if (isset($_SESSION['transaction_msg'])) {
        echo $_SESSION['transaction_msg'];
        unset($_SESSION['transaction_msg']);
    }
    ?>


    <div class="container">
        <div class="checkmark"></div>
        <h2>Payment Successful</h2>
        <p>Thank you for your purchase! Your transaction has been completed.</p>
        <p class="redirect-message">Redirecting to homepage in <span id="timer">5</span> seconds...</p>
    </div>

    <script>
        // Countdown timer before redirection
        let count = 3;
        let timer = document.getElementById("timer");

        setInterval(() => {
            count--;
            timer.textContent = count;
            if (count === 0) {
                window.location.href = "index.php"; // Redirect to homepage (Change URL as needed)
            }
        }, 1000);
    </script>

    </div>

</body>

</html>