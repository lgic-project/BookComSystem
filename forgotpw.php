<?php
include './connection/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']);

    if (empty($email)) {
        $error_message = "Please enter your email!";
    } else {
        if ($conn) {
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                // In real apps, generate a reset token and email it.
                $success_message = "A password reset link has been sent to your email.";
            } else {
                $error_message = "No account found with that email.";
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
    <title>Forgot Password - Sasto E-Pasal</title>
    <link rel="stylesheet" href="./css/forgotpw.css">
</head>
<body>
    <!-- Theme Toggle Button -->
    <div class="theme-toggle">
        <button id="theme-switch" class="toggle-btn">🌞 Light Mode</button>
    </div>

    <div class="forgotpw-container">
        <div class="book-cover">
            <h1>Forgot Password</h1>
        </div>
        <?php if (isset($error_message)) : ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (isset($success_message)) : ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form action="forgotpw.php" method="post">
            <div class="form-group">
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <button type="submit" name="reset" class="btn">Send Reset Link</button>
        </form>
        <p class="switch-link">
            Back to <a href="login.php">Login</a>.
        </p>
    </div>

    <script>
const themeSwitch = document.getElementById('theme-switch');
const body = document.body;
let clickCount = 0;

// Load saved theme from localStorage
const savedTheme = localStorage.getItem('theme') || 'light';
applyTheme(savedTheme);

themeSwitch.addEventListener('click', () => {
    clickCount++;
    if (clickCount === 5) {
        themeSwitch.classList.add('fall-and-break');
        setTimeout(() => {
            themeSwitch.classList.add('broken');
            showSarcasticMessage(); // Display the sarcastic message
        }, 1000); // Add broken effect after the fall animation
        clickCount = 0; // Reset the click counter
    }
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

// Show sarcastic message
function showSarcasticMessage() {
    const message = document.createElement('div');
    message.textContent = "Congratulations! You broke the toggle. Happy now? 🙄";
    message.className = 'sarcastic-message';
    document.body.appendChild(message);

    // Automatically remove the message after 3 seconds
    setTimeout(() => {
        message.remove();
    }, 3000);
}

// Reset button after the "broken" state
themeSwitch.addEventListener('animationend', () => {
    if (themeSwitch.classList.contains('broken')) {
        themeSwitch.classList.remove('fall-and-break', 'broken');
    }
});
    </script>
</body>
</html>
