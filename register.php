<?php
// Handle form submission
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
    // Add further validation and database logic here
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sasto E-Pasal</title>
    <link rel="stylesheet" href="./css/register.css"> <!-- External CSS -->
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
