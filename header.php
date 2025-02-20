<?php
// Check if session is already started
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

require_once './connection/config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id']; // Get user ID from session
$username = $email = $profile_picture = ""; // Initialize variables

// Fetch user details from the database
if ($user_id) {
    $sql = "SELECT username, email, profile_image FROM users WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $stmt->bind_result($username, $email, $profile_picture);
            $stmt->fetch();
        } else {
            die("Error retrieving profile information: " . $mysqli->error);
        }
        $stmt->close();
    } else {
        die("Database error: " . $mysqli->error);
    }
}

// Handle profile update form submission (only profile picture)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile_picture'])) {
    $new_profile_picture = $profile_picture; // Default to current picture

    // Handle profile picture upload
    if (isset($_FILES['new_profile_picture']) && $_FILES['new_profile_picture']['error'] == 0) {
        $upload_dir = 'uploads/userPfp/';

        // Create the upload directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $uploaded_file = $upload_dir . basename($_FILES['new_profile_picture']['name']);

        // Get the file extension and validate the file type
        $file_extension = strtolower(pathinfo($uploaded_file, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_extension, $allowed_extensions)) {
            if (move_uploaded_file($_FILES['new_profile_picture']['tmp_name'], $uploaded_file)) {
                $new_profile_picture = $uploaded_file;
            } else {
                echo "Error uploading new profile picture.";
            }
        } else {
            echo "Invalid file type. Please upload an image file (JPG, JPEG, PNG, or GIF).";
        }
    }

    // Update profile picture in the database
    $update_sql = "UPDATE users SET profile_image = ? WHERE id = ?";
    if ($stmt = $mysqli->prepare($update_sql)) {
        $stmt->bind_param("si", $new_profile_picture, $user_id);
        if ($stmt->execute()) {
            header("Location: profile.php?update=success");
            exit();
        } else {
            echo "Error updating profile picture: " . $mysqli->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Header</title>
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
</head>

<body class="<?php echo $_SESSION['theme']; ?>">
    <header class="header">
        <div class="header-container">
            <!-- Logo -->
            <div class="logo">
                <a href="index.php"><img src="logo/logo-no-slogan-removebg-preview.png" alt="Logo"></a>
            </div>

            <!-- Navigation Bar -->
            <nav class="nav-bar">
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li>
                        <a href="category.php">Categories <i class="fas fa-caret-down"></i></a>
                        <div class="dropdown_menu">
                            <ul>
                                <li><a href="#">Fantasy</a></li>
                                <li><a href="#">Sci-Fi</a></li>
                                <li><a href="#">Biography</a></li>
                                <li><a href="#">Self-Help</a></li>
                                <li><a href="#">Mystery/Thriller</a></li>
                                <li><a href="#">Romance</a></li>
                                <li><a href="#">Horror</a></li>
                                <li><a href="#">History</a></li>
                                <li><a href="#">Other</a></li>
                            </ul>
                        </div>
                    </li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>
                </ul>
            </nav>

            <!-- Search Bar, Cart, and Profile -->
            <div class="header-right">
                <!-- Search Bar -->
                <div class="search-bar">
                    <form action="search_filter.php" method="post">
                        <input type="text" name="search_query" placeholder="Search for books..." />
                        <button type="submit" name="search_query_btn"><i class="fas fa-search"></i></button>
                    </form>
                </div>

                <!-- Shopping Cart -->
                <div class="cart">
                    <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                </div>

                <!-- User Profile -->
                <div class="user-profile">
                    <div class="profile-dropdown">
                        <!-- Display user profile picture -->
                        <img src="<?php echo $profile_picture ? $profile_picture : 'uploads/userPfp/default-avatar.png'; ?>"
                            alt="User Avatar" class="avatar">
                        <div class="dropdown-menu">
                            <ul>
                                <li><a href="profile.php">Profile</a></li>
                                <li><a href="settings.php">Settings</a></li>
                                <li><a href="logout.php">Logout</a></li>
                                <li><a href="index.php">Home</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</body>

</html>