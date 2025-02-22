<?php
session_start();
require_once './connection/config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id']; // Get user ID from session
$username = $email = $profile_picture = $address = $phone_no = ""; // Initialize variables

// Fetch user details from the database
$sql = "SELECT username, email, profile_image, address, phone_no FROM users WHERE id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $stmt->bind_result($username, $email, $profile_picture, $address, $phone_no);
        $stmt->fetch();
    } else {
        die("Error retrieving profile information: " . htmlspecialchars($mysqli->error));
    }
    $stmt->close();
} else {
    die("Database error: " . htmlspecialchars($mysqli->error));
}

// Handle form submission for updating profile details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $new_email = $_POST['email'];
    $new_address = $_POST['address'];
    $new_phone_no = $_POST['phone_no'];
    $new_profile_picture = $profile_picture; // Default to current picture

    // Handle profile picture update
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
    }

    // Update the user's profile details in the database
    $update_sql = "UPDATE users SET email = ?, address = ?, phone_no = ?, profile_image = ? WHERE id = ?";
    if ($stmt = $mysqli->prepare($update_sql)) {
        $stmt->bind_param("ssssi", $new_email, $new_address, $new_phone_no, $new_profile_picture, $user_id);
        if ($stmt->execute()) {
            header("Location: settings.php?update=success");
            exit();
        } else {
            echo "Error updating profile information: " . htmlspecialchars($mysqli->error);
        }
        $stmt->close();
    }
}
?>
<style>
    /* General styles specific to settings page */
.settings-container {
    width: 100%;
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Profile photo section */
.settings-container .profile-photo {
    text-align: center;
    margin-bottom: 20px;
}

.settings-container .profile-photo img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ddd;
    transition: all 0.3s ease;
}

.settings-container .profile-photo img:hover {
    border-color: #007BFF;
}

.settings-container .photo-options {
    margin-top: 10px;
    display: none;
    text-align: center;
}

.settings-container .photo-options button {
    background-color: #007BFF;
    color: #fff;
    border: none;
    padding: 8px 20px;
    border-radius: 30px;
    cursor: pointer;
    margin-top: 5px;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.settings-container .photo-options button:hover {
    background-color: #0056b3;
}

.settings-container .profile-photo:hover .photo-options {
    display: block;
}

/* Form styling */
.settings-container form {
    display: flex;
    flex-direction: column;
}

.settings-container label {
    font-size: 16px;
    margin-bottom: 5px;
    color: #333;
}

.settings-container input[type="email"],
.settings-container input[type="text"],
.settings-container textarea {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    width: 100%;
    background-color: #f9f9f9;
    transition: border 0.3s ease;
}

.settings-container input[type="email"]:focus,
.settings-container input[type="text"]:focus,
.settings-container textarea:focus {
    border-color: #007BFF;
    outline: none;
}

.settings-container textarea {
    resize: vertical;
    min-height: 80px;
}

/* Button styling */
.settings-container button[type="submit"] {
    background-color: #28a745;
    color: #fff;
    padding: 12px 20px;
    font-size: 16px;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.settings-container button[type="submit"]:hover {
    background-color: #218838;
}

/* Modal Styles (for view photo) */
.settings-container .modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
}

.settings-container .modal-content {
    position: relative;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    max-width: 500px;
    width: 100%;
    text-align: center;
}

.settings-container #modal-img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

.settings-container .close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    font-weight: bold;
    color: #333;
    cursor: pointer;
}

.settings-container .close:hover {
    color: #007BFF;
}

/* Upload Photo Form */
.settings-container .upload-photo {
    display: none;
    margin-top: 20px;
    text-align: center;
}

.settings-container .upload-photo input[type="file"] {
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 14px;
}

.settings-container .upload-photo button {
    background-color: #17a2b8;
    color: #fff;
    border: none;
    padding: 8px 20px;
    border-radius: 30px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.settings-container .upload-photo button:hover {
    background-color: #117a8b;
}

.settings-container .upload-photo input[type="file"]:focus,
.settings-container .upload-photo button:hover {
    outline: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .settings-container {
        width: 90%;
        padding: 15px;
    }

    .settings-container .profile-photo img {
        width: 100px;
        height: 100px;
    }

    .settings-container .photo-options button {
        padding: 6px 15px;
        font-size: 13px;
    }

    .settings-container label,
    .settings-container input[type="email"],
    .settings-container input[type="text"],
    .settings-container textarea {
        font-size: 14px;
    }

    .settings-container button[type="submit"] {
        font-size: 14px;
        padding: 10px 18px;
    }

    .settings-container .upload-photo button {
        font-size: 13px;
        padding: 7px 15px;
    }
}

</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <section class="settings-container">
        <h2>Update Your Profile</h2>
        
        <!-- Profile Picture -->
        <div class="profile-photo" id="profile-photo">
            <img src="<?php echo $profile_picture ? htmlspecialchars($profile_picture) : 'default-icon.png'; ?>" alt="Profile Photo" id="profile-img">
            <div class="photo-options" id="photo-options">
                <button id="view-photo">View Photo</button>
                <button id="upload-photo">Upload New Photo</button>
            </div>
        </div>

        <!-- Profile Update Form -->
        <form method="POST" enctype="multipart/form-data">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="address">Address:</label>
            <textarea name="address" id="address" required><?php echo htmlspecialchars($address); ?></textarea>

            <label for="phone_no">Phone Number:</label>
            <input type="text" name="phone_no" id="phone_no" value="<?php echo htmlspecialchars($phone_no); ?>" required>

            <label for="new-profile-picture">Upload a new profile photo:</label>
            <input type="file" name="new_profile_picture" id="new-profile-picture" accept="image/*">

            <button type="submit" name="update_profile">Update Profile</button>
        </form>
    </section>

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
</body>
</html>
