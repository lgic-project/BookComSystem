<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Required files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Function to send OTP email
function sendOTPEmail($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                              // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';         // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                     // Enable SMTP authentication
        $mail->Username   = 'deepakchhantyal4156@gmail.com';  // SMTP write your email
        $mail->Password   = 'jtvbusyczflzxtty';      // SMTP password
        $mail->SMTPSecure = 'ssl';                    // Enable implicit SSL encryption
        $mail->Port       = 465;                      // SMTP port

        // Recipients
        $mail->setFrom('from@example.com', 'Bookly');
        $mail->addAddress($email);  // Add the recipient email

        // Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = 'Your Password Reset OTP';
        $mail->Body    = "Your OTP for password reset is: <strong>$otp</strong><br>Please do not share this OTP with anyone.";
        $mail->AltBody = "Your OTP for password reset is: $otp";  // For non-HTML mail clients

        // Send the email
        $mail->send();
        return true;  // Return true if the email was sent successfully
    } catch (Exception $e) {
        return false;  // Return false if there was an error
    }
}
