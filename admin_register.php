<?php
require_once './connection/config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {

    $username = $mysqli->real_escape_string(trim($_POST['username']));
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $full_name = trim($_POST['full_name']);
    $ph_num = trim($_POST['phone_number']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: register.php?error=empty_fields");
        exit();
    }
    if ($password !== $confirm_password) {
        header("Location: register.php?error=password_mismatch");
        exit();
    }
    if (strlen($password) < 6) {
        header("Location: register.php?error=password_too_short");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: register.php?error= Email Invalid");
        exit();
    }
    $sql = "SELECT admin_id FROM admin WHERE username = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            if ($stmt->num_rows > 0) {
                header("Location: admin_register.php?error=username_taken");
                exit();
            }
        }
        $stmt->close();
    }

    $sql = "SELECT admin_id FROM admin WHERE email = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            if ($stmt->num_rows > 0) {
                header("Location: admin_register.php?error=email_taken");
                exit();
            }
        }
        $stmt->close();
    }

    // Insert new user
    $sql = "INSERT INTO admin (username , password , full_name , email, phone_number) VALUES (?,?,?,?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("sssss", $username,  $hashed_password, $full_name, $email, $ph_num);
        if ($stmt->execute()) {
            header("Location: admin_login.php?signup=success");
            $stmt->close();
            exit();
        } else {
            header("Location: admin_register.php?error=registration_failed");
            $stmt->close();
            exit();
        }
    }

}


$error = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'invalid_password':
            $error = "Invalid password!";
            break;
        case 'user_not_found':
            $error = "User not found!";
            break;
        case 'username_taken':
            $error = "Username is already taken!";
            break;
        case 'registration_failed':
            $error = "Registration failed! Please try again.";
            break;
        case 'database_error':
            $error = "Database error! Please try again.";
            break;
        case 'password_mismatch':
            $error = "Passwords do not match!";
            break;
        case 'password_too_short':
            $error = "Password must be at least 6 characters long!";
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
    <title>Register - Sasto E-Pasal</title>
    <link rel="stylesheet" href="./css/register.css">
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
    <!-- //🌞 Light Mode
    //🌙 Dark Mode -->
    <!-- Theme Toggle Button -->
    <div class="theme-toggle">
        <button id="theme-switch" class="toggle-btn">🌞 Light Mode</button>
    </div>

    <div class="register-container">
        <div class="book-cover">
            <h1>Register - Sasto E-Pasal</h1>
        </div>
        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php elseif (isset($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form action="admin_register.php" id="signup" method="post">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="text" name="full_name" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="phone_number" placeholder="Phone Number" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" placeholder="Confirm your password" required>
            </div>
            <button type="submit" name="signup" class="btn">Register</button>

            <?php
            if (isset($_GET['error']) && in_array($_GET['error'], ['username_taken', 'registration_failed', 'password_mismatch', 'password_too_short', 'empty_fields'])) {
                echo '<div class="error">' . $error . '</div>';
            }
            ?>
        </form>
        <p class="switch-link">
            Already have an account? <a href="admin_login.php">Login here</a>.
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