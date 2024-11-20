<?php
include './connection/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $email = validate($_POST['email']);

    

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data =  htmlspecialchars($data);
    return $data;
}}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sasto E-Pasal</title>
    <link rel="stylesheet" href="./css/register.css">
</head>
<body>
    <div class="register-container">
        <div class="book-cover">
            <h1>Register - Sasto E-Pasal</h1>
        </div>
        <?php if (isset($error_message)) : ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php elseif (isset($success_message)) : ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form action="register.php" id="signup" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>
        <p class="switch-link">
            Already have an account? <a href="login.php">Login here</a>.
        </p>
    </div>
</body>
</html>
