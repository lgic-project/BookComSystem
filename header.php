<?php
// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once './connection/config.php';




// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
json_encode(["cartCount" => $cartCount]);

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
    <title>Header</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- <style>
        .search-results {
            position: absolute;
            background: #fff;
            border: 1px solid #ccc;
            width: 250px;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        .search-results ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .search-results li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .search-results li a {
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
        }
        .search-results img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
    </style> -->
</head>

<body class="<?php echo $_SESSION['theme'] ?? 'default-theme'; ?>">
    <header class="header">
        <div class="header-container">
            <div class="logo">
                <a href="index.php"><img src="logo/logo-no-slogan-removebg-preview.png" alt="Logo"></a>
            </div>

            <nav class="nav-bar">
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li>
                        <a href="category.php">Categories </i></a>
                        <!-- <i class="fas fa-caret-down"> -->
                        <!-- <div class="dropdown_menu">
                            <ul>
                                <li><a href="./category.php?category=fantasy">Fantasy</a></li>
                                <li><a href="./category.php?category=sci-fi">Sci-Fi</a></li>
                                <li><a href="./category.php?category=biography">Biography</a></li>
                                <li><a href="./category.php?category=self-help">Self-Help</a></li>
                                <li><a href="./category.php?category=mystery/thriller">Mystery/Thriller</a></li>
                                <li><a href="./category.php?category=romance">Romance</a></li>
                                <li><a href="./category.php?category=horror">Horror</a></li>
                                <li><a href="./category.php?category=history">History</a></li>
                                <li><a href="./category.php?category=other">Other</a></li>
                            </ul>
                        </div> -->
                    </li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>
                </ul>
            </nav>

            <div class="header-right">
                <div class="search-bar">
                    <form action="search_filter.php" method="post">
                        <input type="text" name="search_query" placeholder="Search for books..." value="<?php echo isset($search_query) ? $search_query : ''; ?>"
                        />
                        <button type="submit" name="search_query_btn"><i class="fas fa-search"></i></button>
                    </form>

                    <!-- Search Results Dropdown -->

                </div>

                <!-- Shopping Cart -->
                <div style="position: relative; display: inline-block;">
                    <a href="cart.php"><i class="fa fa-shopping-cart" style="font-size: 24px;"></i></a>
                    <span
                        style="position: absolute; top: -5px; right: -10px; background: red; color: white; font-size: 12px; padding: 2px 5px; border-radius: 50%;">
                        <?php echo $cartCount; ?>
                    </span>
                </div>

                <div class="user-profile">
                    <div class="profile-dropdown">
                        <img src="<?php echo $profile_picture ? $profile_picture : 'uploads/userPfp/default-avatar.png'; ?>" alt="User Avatar" class="avatar">
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
    <script>
        function updateCartCount() {
            fetch("header.php")
                .then(response => response.json())
                .then(data => {
                    document.getElementById("cartCount").textContent = data.cartCount;
                })
                .catch(error => console.error("Error fetching cart count:", error));
        }

        // Call function on page load
        document.addEventListener("DOMContentLoaded", updateCartCount);
    </script>
</body>


</html>
