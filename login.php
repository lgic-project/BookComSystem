<?php
// Include the database connection
require_once './connection/config.php';

// Start the session
session_start();

// Handle login request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST['password']);
    // Get the input data
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email and password are provided
    if (empty($email) || empty($password)) {
        header("Location: login.php?error=empty_fields");
        exit();
    }

    // Prepare the SQL query to check if the user exists
    $sql = "SELECT id, username, password FROM users WHERE email = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind the email parameter
        $stmt->bind_param("s", $email);

        // Execute the query
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            // Check if a user is found
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                
                // Verify the password
                if (password_verify($password, $row['password'])) {
                    // Successful login: Set session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $row["id"];
                    $_SESSION["username"] = $row["username"];
                    
                    // Optionally, set other session variables like avatar if needed
                    // $_SESSION['user_avatar'] = 'path_to_avatar_image';

                    // Redirect to index page or any other page
                    header("Location: index.php");
                    exit();
                } else {
                    // Invalid password error
                    header("Location: login.php?error=invalid_password");
                    exit();
                }
            } else {
                // User not found error
                header("Location: login.php?error=user_not_found");
                exit();
            }
        } else {
            // Database query error
            header("Location: login.php?error=database_error");
            exit();
        }
    }
}

// Handle login error messages
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

        <!-- Display Error Message if any -->
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>

        <p class="switch-link">
            <a href="forgotpw.php">Forgot Password?</a>.
        </p>
        <p class="switch-link">
            Don't have an account? <a href="register.php">Register here</a>.
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
