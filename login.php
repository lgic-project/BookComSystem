<?php

require_once './connection/config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password']);


    if (empty($username) || empty($password)) {
        header("Location: login.php?error=empty_fields");
        exit();
    }
    $sql = "SELECT id, username, password FROM user WHERE username = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $username);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($password, $row['password'])) {
                    session_start();
                    $_SESSION["login_success"] = true;
                    $_SESSION["id"] = $row["id"];
                    $_SESSION["username"] = $row["username"];
                    header("Location: index.php");
                    exit();
                } else {
                    header("Location: login.php?error=invalid_password");
                    exit();
                }
            } else {
                header("Location: login.php?error=user_not_found");
                mysqli_stmt_close($stmt);
                exit();
            }
        } else {
            header("Location: login.php?error=database_error");
            mysqli_stmt_close($stmt);
            exit();
        }
    }

    mysqli_close($conn);

}


// login error get 
$error = '';
if(isset($_GET['error'])) {
    switch($_GET['error']) {
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
            $error="";
            break;
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
    <style>
        .error{
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
        <button id="theme-switch" class="toggle-btn">
            🌞 Light Mode
        </button>
    </div>

    <div class="login-container">
        <div class="book-cover">
            <h1>Login - Sasto E-Pasal</h1>
        </div>
        <?php if (isset($error_message)): ?>
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
            <?php
            if (isset($_GET['error']) && in_array($_GET['error'], ['invalid_password', 'user_not_found', 'database_error'])) {
                echo "<div class='error'>$error</div>";
            };
            ?>
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