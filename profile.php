<?php
session_start();
require_once './connection/config.php';

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

// $user_id = $_SESSION['user_id']; // Get user ID from session
// $username = $email = $profile_picture = ""; // Initialize variables

// // Fetch user details from the database
// $sql = "SELECT username, email, profile_picture FROM users WHERE id = ?";
// if ($stmt = $mysqli->prepare($sql)) {
//     $stmt->bind_param("i", $user_id);
//     if ($stmt->execute()) {
//         $stmt->bind_result($username, $email, $profile_picture);
//         $stmt->fetch();
//     } else {
//         die("Error retrieving profile information: " . $mysqli->error);
//     }
//     $stmt->close();
// } else {
//     die("Database error: " . $mysqli->error);
// }

// Handle profile update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $new_username = $mysqli->real_escape_string(trim($_POST['username']));
    $new_email = trim($_POST['email']);
    $new_profile_picture = $profile_picture; // Default to current picture

    // Handle profile picture upload
    if (isset($_FILES['new_profile_picture']) && $_FILES['new_profile_picture']['error'] == 0) {
        $upload_dir = 'uploads/';
        $uploaded_file = $upload_dir . basename($_FILES['new_profile_picture']['name']);
        if (move_uploaded_file($_FILES['new_profile_picture']['tmp_name'], $uploaded_file)) {
            $new_profile_picture = $uploaded_file;
        } else {
            echo "Error uploading new profile picture.";
        }
    }

    // Update user details in the database
    $update_sql = "UPDATE users SET username = ?, email = ?, profile_picture = ? WHERE id = ?";
    if ($stmt = $mysqli->prepare($update_sql)) {
        $stmt->bind_param("sssi", $new_username, $new_email, $new_profile_picture, $user_id);
        if ($stmt->execute()) {
            header("Location: profile.php?update=success");
            exit();
        } else {
            echo "Error updating profile: " . $mysqli->error;
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
    <title>Your Profile</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
<?php include 'header.php'; ?>
    <h1>Your Profile</h1>
    <form action="profile.php" method="post" enctype="multipart/form-data" class="profile-form">
        <div class="form-group">
            <label for="username">Username:</label>
            <select id="username" name="username" required>
                <option value="">Select Username</option>
                <option value="user1" <?php echo $username == 'user1' ? 'selected' : ''; ?>>user1</option>
                <option value="user2" <?php echo $username == 'user2' ? 'selected' : ''; ?>>user2</option>
                <option value="user3" <?php echo $username == 'user3' ? 'selected' : ''; ?>>user3</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <select id="email" name="email" required>
                <option value="">Select Email</option>
                <option value="user1@example.com" <?php echo $email == 'user1@example.com' ? 'selected' : ''; ?>>user1@example.com</option>
                <option value="user2@example.com" <?php echo $email == 'user2@example.com' ? 'selected' : ''; ?>>user2@example.com</option>
                <option value="user3@example.com" <?php echo $email == 'user3@example.com' ? 'selected' : ''; ?>>user3@example.com</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="profile_picture">Profile Picture:</label>
            <img src="<?php echo $profile_picture ? htmlspecialchars($profile_picture) : 'default.jpg'; ?>" alt="Profile Picture" class="profile-img">
            <input type="file" id="new_profile_picture" name="new_profile_picture" accept="image/*">
        </div>
        
        <button type="submit" name="update_profile">Update Profile</button>
    </form>
</body>

</html>
