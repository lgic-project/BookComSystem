<?php

require_once './connection/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);


    if (empty($username) || empty($password)) {
        header("Location: admin_login.php?error=empty_fields");
        exit();
    }
    $sql = "SELECT admin_id, username, password FROM admin WHERE username = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $row["admin_id"];
                    $_SESSION["username"] = $row["username"];
                    header("Location: admin_dashboard.php");
                    $stmt->close();
                    exit();
                } else {
                    header("Location: login.php?error=invalid_password");
                    $stmt->close();
                    exit();
                }
            } else {
                header("Location: admin_login.php?error=user_not_found");
                $stmt->close();
                exit();
            }
        } else {
            header("Location: admin_login.php?error=database_error");
            $stmt->close();
            exit();
        }
    }
}

session_abort();


// login error get 
$error = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'invalid_password':
            $error = "Invalid password!";
            break;
        case 'user_not_found':
            $error = "User not found!";
            break;
        case 'database_error':
            $error = "Database error! Please try again.";
            break;
        case 'empty_fields':
            $error = "All fields are required!";
            break;
        default:
            $error = "";
            break;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bookly</title>
    <link rel="stylesheet" href="./css/login.css">
    <style>
        .error {
            background-color: #552f33;
            color: white;
            margin: 8px;
            padding: 7px;
        }
    </style>
</head>

<body>
    
    <!-- Theme Toggle Button -->
    <div class="theme-toggle">
        <button id="theme-switch" class="toggle-btn">🌞 Light Mode</button>
    </div>

    <div class="login-container">
        <div class="book-cover">
            <h1>Login - Bookly</h1>
        </div>
        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="admin_login.php" method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn">Login</button>
            <?php
            if (isset($_GET['error']) && in_array($_GET['error'], ['invalid_password', 'user_not_found', 'database_error'])) {
                echo "<div class='error'>$error</div>";
            }
            ;
            ?>
            <p class="switch-link">
                <a href="forgotpw.php">Forgot Password?</a>.
            </p>
            <p>
            <a href="login.php">User Login</a>
            </p>

        </form>
        <p class="switch-link">
            Don't have an account? <a href="admin_register.php">Register here</a>.
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