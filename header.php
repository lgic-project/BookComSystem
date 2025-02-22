<?php
// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once './connection/config.php';

// Handle search query
$search_query = "";
$search_results = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['search_query_btn'])) {
    $search_query = isset($_POST['search_query']) ? trim($_POST['search_query']) : '';

    if (!empty($search_query)) {
        // Query to find books with titles matching the search query
        $sql = "SELECT id, title, book_img FROM books WHERE title LIKE ?";

        if ($stmt = $mysqli->prepare($sql)) {
            $search_param = "%$search_query%"; // Matches partial text
            $stmt->bind_param("s", $search_param);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $search_results[] = $row;
                }
            }
            $stmt->close();
        }
    }
}

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
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.querySelector('input[name="search_query"]');
            const searchResults = document.querySelector('.search-results');

            searchInput.addEventListener("input", function () {
                if (this.value.length > 0) {
                    searchResults.style.display = "block";
                } else {
                    searchResults.style.display = "none";
                }
            });

            document.addEventListener("click", function (event) {
                if (!searchResults.contains(event.target) && event.target !== searchInput) {
                    searchResults.style.display = "none";
                }
            });
        });
    </script>
    <style>
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
    </style>
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
                    <li><a href="category.php">Categories</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>
                </ul>
            </nav>

            <div class="header-right">
                <div class="search-bar">
                    <form action="" method="post">
                        <input type="text" name="search_query" placeholder="Search for books..." value="<?php echo htmlspecialchars($search_query); ?>" />
                        <button type="submit" name="search_query_btn"><i class="fas fa-search"></i></button>
                    </form>

                    <!-- Search Results Dropdown -->
                    <?php if (!empty($search_results)): ?>
                        <div class="search-results">
                            <ul>
                                <?php foreach ($search_results as $book): ?>
                                    <li>
                                        <a href="book_details.php?id=<?php echo $book['id']; ?>">
                                            <img src="uploads/<?php echo $book['book_img']; ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
                                            <?php echo htmlspecialchars($book['title']); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="cart">
                    <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
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
</body>
</html>
