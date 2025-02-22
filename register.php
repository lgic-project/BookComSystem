<?php
// Include the database connection
require_once './connection/config.php';

// Start the session
session_start();

// Handle register request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input data
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = trim($_POST['password']);
    $username = $mysqli->real_escape_string($_POST['username']);
    $address = $mysqli->real_escape_string($_POST['address']);
    $phone_no = $mysqli->real_escape_string($_POST['phone_no']);

    // Check if fields are empty
    if (empty($email) || empty($password) || empty($username) || empty($address) || empty($phone_no)) {
        header("Location: register.php?error=empty_fields");
        exit();
    }

    // Check if email already exists
    $sql = "SELECT id FROM users WHERE email = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                header("Location: register.php?error=email_exists");
                exit();
            } else {
                // Register the user
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (username, email, password, address, phone_no) VALUES (?, ?, ?, ?, ?)";
                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->bind_param("sssss", $username, $email, $hashed_password, $address, $phone_no);
                    if ($stmt->execute()) {
                        header("Location: login.php?message=registration_successful");
                        exit();
                    } else {
                        header("Location: register.php?error=database_error");
                        exit();
                    }
                }
            }
        }
    }
}

// Handle registration error messages
$error = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'email_exists':
            $error = "Email already exists!";
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
    <title>Register - Bookly</title>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>

    <!-- Theme Toggle Button -->
    <div class="theme-toggle">
        <button id="theme-switch" class="toggle-btn">🌞 Light Mode</button>
    </div>

    <div class="login-container">
        <div class="book-cover">
            <h1>Register - Bookly</h1>
        </div>

        <!-- Display Error Message if any -->
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="text" name="address" placeholder="Address" required>
            </div>
            <div class="form-group">
                <input type="text" name="phone_no" placeholder="Phone Number" required>
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
                }, 1000);
                clickCount = 0;
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
