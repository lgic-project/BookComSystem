<?php
session_start();
include './connection/config.php'; // Database connection file
require './mail.php'; // Include the mail.php file that contains the sendOTPEmail function

// Function to generate a random OTP
function generateOTP($length = 8) {
    return str_pad(mt_rand(0, 99999999), $length, '0', STR_PAD_LEFT);
}

// Handle OTP request form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_otp'])) {
    $email = htmlspecialchars(trim($_POST['email']));
    
    if (empty($email)) {
        $error_message = "Please enter your email!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format!";
    } else {
        // Check if the email exists in the database
        if ($mysqli) {
            $sql = "SELECT * FROM users WHERE email = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    // Generate and store OTP in session
                    $otp = generateOTP();
                    $_SESSION['otp'] = $otp;
                    $_SESSION['email'] = $email;

                    // Call the sendOTPEmail function to send OTP via email
                    if (sendOTPEmail($email, $otp)) {
                        $success_message = "An OTP has been sent to your email. Please check your inbox.";
                        $_SESSION['otp_sent'] = true; // Mark OTP as sent
                    } else {
                        $error_message = "Failed to send OTP.";
                    }
                } else {
                    $error_message = "No account found with that email.";
                }
                $stmt->close();
            } else {
                $error_message = "Failed to prepare the query: " . $mysqli->error;
            }
        } else {
            $error_message = "Database connection failed!";
        }
    }
}

// Handle password reset form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset_password'])) {
    $entered_otp = htmlspecialchars(trim($_POST['otp']));
    $new_password = htmlspecialchars(trim($_POST['new_password']));
    $retype_password = htmlspecialchars(trim($_POST['retype_password']));

    if (empty($entered_otp) || empty($new_password) || empty($retype_password)) {
        $error_message = "All fields are required!";
    } elseif ($entered_otp != $_SESSION['otp']) {
        $error_message = "Invalid OTP!";
    } elseif ($new_password !== $retype_password) {
        $error_message = "Passwords do not match!";
    } else {
        // Update password in the database
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $email = $_SESSION['email'];

        $sql = "UPDATE users SET password = ? WHERE email = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ss", $hashed_password, $email);
            if ($stmt->execute()) {
                // Redirect to login page after successful password reset
                header('Location: login.php');
                exit();  // Make sure to stop the script execution after the redirect
            } else {
                $error_message = "Failed to update password: " . $mysqli->error;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="./css/forgotpw.css">
</head>
<body>
    <div class="forgotpw-container">
        <h1>Forgot Password</h1>
        <?php if (isset($error_message)) : ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (isset($success_message)) : ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (!isset($_SESSION['otp_sent'])) : ?>
            <!-- Email Input Form -->
            <form action="" method="post">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <button type="submit" name="send_otp" class="btn">Send OTP</button>
            </form>
        <?php else: ?>
            <!-- OTP and Password Input Form -->
            <form action="" method="post">
                <div class="form-group">
                    <input type="text" name="otp" placeholder="Enter OTP" required>
                </div>
                <div class="form-group">
                    <input type="password" name="new_password" placeholder="Enter new password" required>
                </div>
                <div class="form-group">
                    <input type="password" name="retype_password" placeholder="Retype new password" required>
                </div>
                <button type="submit" name="reset_password" class="btn">Reset Password</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
