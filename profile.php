<?php
session_start();
require_once './connection/config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['username']; // Get user ID from session
$username = $email = $profile_picture = ""; // Initialize variables

// Fetch user details from the database
$sql = "SELECT username, email, profile_picture FROM users WHERE id = ?";
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
    <section class="profile-container">
        <div class="profile-header">
            <div class="profile-photo" id="profile-photo">
                <img src="<?php echo $profile_picture ? $profile_picture : 'default-icon.png'; ?>" alt="Profile Photo" id="profile-img">
                <div class="photo-options" id="photo-options">
                    <button id="view-photo">View Photo</button>
                    <button id="upload-photo">Upload Photo</button>
                </div>
            </div>
        </div>

        <div class="user-details">
            <h2>Details</h2>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <!-- Add more user details as needed -->
        </div>
    </section>

    <!-- Modal for Viewing Photo -->
    <div class="modal" id="photo-modal">
        <div class="modal-content">
            <span class="close" id="close-modal">&times;</span>
            <img src="<?php echo $profile_picture ? $profile_picture : 'default-icon.png'; ?>" alt="Profile Photo" id="modal-img">
        </div>
    </div>

    <!-- Upload Photo Form -->
    <div class="upload-photo" id="upload-photo-form">
        <form action="upload-photo.php" method="POST" enctype="multipart/form-data">
            <label for="new-profile-photo">Upload a new profile photo:</label>
            <input type="file" name="new-profile-photo" id="new-profile-photo" accept="image/*" required>
            <button type="submit" name="upload-photo">Upload</button>
        </form>
    </div>

    <script src="js/profile.js"></script>
</body>
</html>