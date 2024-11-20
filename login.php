<?php
session_start();
$login_success = false;
include './connection/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    if(empty($username) || empty($password)) {
        header("Location: index.php?error=empty_fields");
        exit();
    }

    $C = connect();
    if($c){
        $sql = "Select * from users where username='$username' AND password='$password'";
        $result = $conn->query($sql);
    if ($login_success) {
        header('Location: dashboard.php');
        exit();
    }
}

    function validate($data){
        $data = trim($data);
        $data =  htmlspecialchars($data);
        return $data;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sasto E-Pasal</title>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <!-- Theme Toggle Button -->
    <div class="theme-toggle">
        <button id="theme-switch" class="toggle-btn">
            🌞 Light Mode
        </button>
    </div>

    <div class="login-container">
        <div class="book-cover">
            <h1>Login - Sasto E-Pasal</h1>
        </div>
        <?php if (isset($error_message)) : ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="login.php" id="login" method="post">
            <div class="form-group">
                <!-- <label for="username">Username</label> -->
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <!-- <label for="password">Password</label> -->
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <p class="switch-link">
            Don't have an account? <a href="register.php">Register here</a>.
        </p>
    </div>

    <script>
        const themeSwitch = document.getElementById('theme-switch');
        const body = document.body;

        // Load saved theme from localStorage
        const savedTheme = localStorage.getItem('theme') || 'light';
        applyTheme(savedTheme);

        // Event listener for theme toggle button
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
