<?php
session_start();
include './connection/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        $error_message = "All fields are required!";
    } else {
        $conn = connect();
        if ($conn) {
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            if ($conn->query($sql)) {
                $success_message = "Registration successful!";
            } else {
                $error_message = "Error: " . $conn->error;
            }
        } else {
            $error_message = "Database connection failed!";
        }
    }
}
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
    <!-- Theme Toggle Button -->
    <div class="theme-toggle">
        <button id="theme-switch" class="toggle-btn">🌞 Light Mode</button>
    </div>

    <div class="register-container">
        <div class="book-cover">
            <h1>Register - Sasto E-Pasal</h1>
        </div>
        <?php if (isset($error_message)) : ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php elseif (isset($success_message)) : ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="signup" class="btn">Register</button>
        </form>
        <p class="switch-link">
            Already have an account? <a href="login.php">Login here</a>.
        </p>
    </div>

    <script>
        const themeSwitch = document.getElementById('theme-switch');
        const body = document.body;

        // Load saved theme from localStorage
        const savedTheme = localStorage.getItem('theme') || 'light';
        applyTheme(savedTheme);

        themeSwitch.addEventListener('click', () => {
            const currentTheme = body.classList.contains('dark-mode') ? 'dark' : 'light';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            applyTheme(newTheme);
        });

        function applyTheme(theme) {
            if (theme === 'dark') {
                body.classList.add('dark-mode');
                body.classList.remove('light-mode');
                themeSwitch.textContent = '🌙 Dark Mode';
                localStorage.setItem('theme', 'dark');
            } else {
                body.classList.add('light-mode');
                body.classList.remove('dark-mode');
                themeSwitch.textContent = '🌞 Light Mode';
                localStorage.setItem('theme', 'light');
            }
        }
    </script>
</body>
</html>
