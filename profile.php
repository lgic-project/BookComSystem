<?php
session_start();
require_once './connection/config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id']; // Get user ID from session
$username = $email = $profile_picture = ""; // Initialize variables

// Fetch user details from the database
$sql = "SELECT username, email, profile_image FROM users WHERE id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $stmt->bind_result($username, $email, $profile_picture);
        $stmt->fetch();
    } else {
        die("Error retrieving profile information: " . htmlspecialchars($mysqli->error));
    }
    $stmt->close();
} else {
    die("Database error: " . htmlspecialchars($mysqli->error));
}

// Handle profile update form submission (only profile picture)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile_picture'])) {
    $new_profile_picture = $profile_picture; // Default to current picture

    // Check if a file was uploaded
    if (isset($_FILES['new_profile_picture']) && $_FILES['new_profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/userPfp/';
        
        // Create the upload directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $uploaded_file = $upload_dir . basename($_FILES['new_profile_picture']['name']);
        
        // Validate file type and size
        $file_extension = strtolower(pathinfo($uploaded_file, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $max_file_size = 2 * 1024 * 1024; // 2 MB

        if (in_array($file_extension, $allowed_extensions)) {
            if ($_FILES['new_profile_picture']['size'] <= $max_file_size) {
                // Generate a unique file name to prevent overwriting
                $unique_file_name = $upload_dir . uniqid('profile_', true) . '.' . $file_extension;

                if (move_uploaded_file($_FILES['new_profile_picture']['tmp_name'], $unique_file_name)) {
                    $new_profile_picture = $unique_file_name;
                } else {
                    echo "Error uploading new profile picture.";
                }
            } else {
                echo "File is too large. Maximum allowed size is 2 MB.";
            }
        } else {
            echo "Invalid file type. Please upload an image file (JPG, JPEG, PNG, or GIF).";
        }
    } elseif (isset($_FILES['new_profile_picture']) && $_FILES['new_profile_picture']['error'] !== UPLOAD_ERR_NO_FILE) {
        echo "Error uploading file: " . htmlspecialchars($_FILES['new_profile_picture']['error']);
    }

    // Update profile picture in the database
    $update_sql = "UPDATE users SET profile_image = ? WHERE id = ?";
    if ($stmt = $mysqli->prepare($update_sql)) {
        $stmt->bind_param("si", $new_profile_picture, $user_id);
        if ($stmt->execute()) {
            header("Location: profile.php?update=success");
            exit();
        } else {
            echo "Error updating profile picture: " . htmlspecialchars($mysqli->error);
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
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> -->

</head>
<body>
    <?php include 'header.php'; ?>
    <section class="profile-container">
        <div class="profile-header">
            <div class="profile-photo" id="profile-photo">
                <img src="<?php echo $profile_picture ? htmlspecialchars($profile_picture) : 'default-icon.png'; ?>" alt="Profile Photo" id="profile-img">
                <div class="photo-options" id="photo-options">
                    <button id="view-photo">View Photo</button>
                    <button id="upload-photo">Upload Photo</button>
                </div>
            </div>
        </div>
        <script>
document.getElementById('profile-photo').addEventListener('click', function(event) {
    if (event.target.id === 'view-photo') {
        // Open the view photo modal
        document.getElementById('photo-modal').style.display = 'flex';
    } else if (event.target.id === 'upload-photo') {
        // Show the upload photo form
        document.getElementById('upload-photo-form').style.display = 'block';
    }
});

// Close modal when the user clicks the close button
document.getElementById('close-modal').addEventListener('click', function() {
    document.getElementById('photo-modal').style.display = 'none';
});

// Close modal if user clicks outside of it
window.onclick = function(event) {
    if (event.target === document.getElementById('photo-modal')) {
        document.getElementById('photo-modal').style.display = 'none';
    }
};
</script>
        
        <div class="user-details">
            <h2>Details</h2>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        </div>
    </section>
    
    <!-- Modal for Viewing Photo -->
    <div class="modal" id="photo-modal">
        <div class="modal-content">
            <span class="close" id="close-modal">&times;</span>
            <img src="<?php echo $profile_picture ? htmlspecialchars($profile_picture) : 'default-icon.png'; ?>" alt="Profile Photo" id="modal-img">
        </div>
    </div>
    
    <!-- Upload Photo Form -->
    <div class="upload-photo" id="upload-photo-form">
        <form method="POST" enctype="multipart/form-data">
            <label for="new-profile-picture">Upload a new profile photo:</label>
            <input type="file" name="new_profile_picture" id="new-profile-picture" accept="image/*">
            <button type="submit" name="update_profile_picture">Upload</button>
        </form>
    </div>

</body>
</html>
