<?php
session_start();
require_once './connection/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email, profile_picture FROM users WHERE id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $stmt->store_result();
        $stmt->bind_result($username, $email, $profile_picture);
        $stmt->fetch();
    } else {
        echo "Error retrieving profile information.";
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $new_username = $mysqli->real_escape_string(trim($_POST['username']));
    $new_email = trim($_POST['email']);
    
    $new_profile_picture = $profile_picture; // Keep old picture by default
    if (isset($_FILES['new_profile_picture']) && $_FILES['new_profile_picture']['error'] == 0) {
        $new_profile_picture = 'uploads/' . basename($_FILES['new_profile_picture']['name']);
        move_uploaded_file($_FILES['new_profile_picture']['tmp_name'], $new_profile_picture);
    }

    $sql = "UPDATE users SET username = ?, email = ?, profile_picture = ? WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sssi", $new_username, $new_email, $new_profile_picture, $user_id);
        if ($stmt->execute()) {
            header("Location: profile.php?update=success");
        } else {
            echo "Error updating profile.";
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
</head>

<body>
    <h1>Your Profile</h1>
    <form action="profile.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        <div>
            <label for="profile_picture">Profile Picture:</label>
            <img src="<?php echo $profile_picture ? $profile_picture : 'default.jpg'; ?>" alt="Profile Picture" width="100">
            <input type="file" name="new_profile_picture" accept="image/*">
        </div>
        <button type="submit" name="update_profile">Update Profile</button>
    </form>
</body>

</html>
