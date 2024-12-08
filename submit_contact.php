<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $message = $_POST['message'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $to = "bsaladkari@gmail.com";
        $subject = "New Contact Us Message";
        $body = "Name: $name\nEmail: $email\nNumber: $number\nMessage:\n$message";

        if (mail($to, $subject, $body)) {
            echo "<script>alert('Message sent successfully'); window.location.href = 'contactus.php';</script>";
        } else {
            echo "<script>alert('Failed to send message, please try again.'); window.location.href = 'contactus.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid email address'); window.location.href = 'contactus.php';</script>";
    }
}
?>
