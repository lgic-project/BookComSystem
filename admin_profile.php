<?php
session_start();
$error = "";
$_SESSION['username'] = "Deepak";
$username = $_SESSION['username'];
$admin_id = 1;

require_once './connection/config.php';

$stmt = $mysqli->prepare("SELECT * FROM admin WHERE admin_id=?");
$stmt->bind_param('i', $admin_id);

$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $full_name = $row['full_name'];
        $email = $row['email'];
        $phone = $row['phone_number'];
        $profile_img = $row['profile_img'];
    }
}

$edit_before = true;
$edit_after = false;
if (isset($_POST['edit_profile'])) {
    $edit_before = false;
    $edit_after = true;
}

$change_password = false;
if (isset($_POST['change_password'])) {
    $change_password = true;
    $edit_before = false;
    $edit_after = false;
}

if (isset($_POST['update_cancel'])) {
    $edit_before = true;
    $change_password = false;
    $edit_after = false;
}

if (isset($_POST['update_password'])) {
    $old_password = $mysqli->real_escape_string($_POST['old_password']);
    $new_password = $mysqli->real_escape_string($_POST['new_password']);
    $confirm_new_password = $mysqli->real_escape_string($_POST['confirm_new_password']);
    $admin_id = $_POST['admin_id'];

    $sql = "SELECT password FROM admin WHERE admin_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $current_password = $row['password'];

    if (password_verify($old_password, $current_password)) {
        if ($new_password == $confirm_new_password) {
            $new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE admin SET password = ? WHERE admin_id = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $new_password, $admin_id);
            if ($stmt->execute()) {
                header("Location: admin_profile.php?message=Password updated successfully!&change_password=true");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            $error = "New password and confirm password do not match!";
        }
    } else {
        $error = "Old password is incorrect!";
    }
}

if ($error) {
    $edit_before = false;
    $edit_after = false;
    $change_password = true;
}

if (isset($_GET['message'])) {
    if (isset($_GET['change_password'])) {
        $error = $_GET['message'];
        $edit_before = true;
        $edit_after = false;
        $change_password = false;
    }

    if (isset($_GET['edit_profile'])) {
        $error = $_GET['message'];
        $edit_before = true;
        $edit_after = false;
        $change_password = false;
    }
}

if (isset($_POST['update'])) {
    // Get form data
    $admin_id = $_POST['admin_id'];
    $full_name = $mysqli->real_escape_string($_POST['full_name']);
    $username = $mysqli->real_escape_string($_POST['username']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $phone = $mysqli->real_escape_string($_POST['phone']);

    // Handle file upload
    $profile_pic = $_FILES['profile_pic']['name'];
    $target_dir = "developerpic/";
    $target_file = $target_dir . basename($profile_pic);

    // Fetch current profile picture
    $query = "SELECT profile_img FROM admin WHERE admin_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $current_pic = $row['profile_img'];

    if (!empty($profile_pic)) {
        // Validate file type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (in_array($file_type, $allowed_types)) {
            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
                // Delete the old profile picture if it exists
                if (!empty($current_pic) && file_exists($target_dir . $current_pic)) {
                    unlink($target_dir . $current_pic);
                }

                // Update profile with new image
                $sql = "UPDATE admin SET full_name = ?, username = ?, email = ?, phone_number = ?, profile_img = ? WHERE admin_id = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("sssssi", $full_name, $username, $email, $phone, $profile_pic, $admin_id);
                // Execute query
                if ($stmt->execute()) {
                    header("Location: admin_profile.php?message=Profile updated successfully!&edit_profile=true");
                    exit();
                } else {
                    header("Location: admin_profile.php?message=Error updating profile. Please try again.&edit_profile=true");
                    exit();
                }

            } else {
                header("Location: admin_profile.php?message=Error uploading file. Please try again.&edit_profile=true");
                exit();
            }
        } else {
            header("Location: admin_profile.php?message=Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.&edit_profile=true");
            exit();
        }
    } else {
        // Update profile without changing image
        $sql = "UPDATE admin SET full_name = ?, username = ?, email = ?, phone_number = ? WHERE admin_id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssssi", $full_name, $username, $email, $phone, $admin_id);
        // Execute query
        if ($stmt->execute()) {
            header("Location: admin_profile.php?message=Profile updated successfully!&edit_profile=true");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }


    // Close statement
    $stmt->close();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="./css/admindashboard.css">

    <title>Dashboard Admin: <?php echo $username ?> </title>
</head>
<style>
    #main-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .container {
        padding: 30px;
        display: flex;
        flex-direction: row;
        gap: 40px;
    }



    .img-container img {
        width: 200px;
        height: 250px;
        border-radius: 20%;
        overflow: hidden;
    }

    form {
        display: flex;
        flex-direction: row;
        justify-content: center;
        gap: 20px;
    }

    form .input-fields {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    form .img-container {
        display: flex;
        flex-direction: column;
    }

    /* Error Message Container */
    .errormsg {
        display: flex;
        justify-content: center;
        margin: 10px auto;
        width: 90%;
        max-width: 600px;
        position: relative;
    }

    /* Error Message Box */
    .error-msg {
        display: flex;
        flex-direction: column;
        align-items: center;
        background: #4b49AC;
        /* Your Main Color */
        color: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
        font-size: 1rem;
        font-weight: bold;
        position: relative;
        opacity: 0;
        transform: translateY(-10px);
        animation: fadeIn 0.5s forwards;
    }

    /* Close Button */
    .error-msg .close-btn {
        position: absolute;
        top: 8px;
        right: 12px;
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
        transition: 0.3s;
    }

    .error-msg .close-btn:hover {
        color: #F3797E;
        /* Light Red */
    }

    /* Fade-in Animation */
    @keyframes fadeIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 500px) {
        .error-msg {
            font-size: 0.9rem;
            padding: 12px;
        }
    }


    form .img-container input[type='file'] {
        width: 200px;
        height: 30px;
        border-radius: 5px;
        padding: 10px;
    }

    .input-fields input {
        width: 250px;
        height: 30px;
        font-size: large;
        border-radius: 5px;
        padding: 10px;
    }

    .input-fields input[type="submit"] {
        width: auto;
        height: 40px;
        background-color: #98BDFF;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .input-fields input[type="submit"]:hover {
        width: auto;
        height: 40px;
        background-color: #4b49AC;
        color: white;
        border-radius: 5px;
    }

    .update-btn {
        display: flex;
        flex-direction: row;
        gap: 20px;
    }

    .update-btn input[value="cancel"]:hover {
        background-color: #FF0000;
    }

    .pass-btn-can {
        text-align: center;
        background-color: #98BDFF;
        color: white;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .pass-btn-can:hover {
        text-align: center;
        background-color: #FF0000;
        color: white;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
    }



    .change-pass {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
</style>

<body>
    <!-- SIDEBAR -->
    <?php include "admin_sidebar.php"; ?>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>

            <a href="#" class="nav-link">Profile </a>
            <div class="nav-link-2">
                <a href="#" class="profile">
                    <img src="img/people.png">
                </a>
            </div>
        </nav>
        <!-- NAVBAR -->

        <div class="profile-container" id="main-content">
            <?php if (!empty($error)) {
                ?>
                <div class="errormsg">
                    <?php echo "<h1 class='error-msg'>$error</h1>"; ?>
                </div>
            <?php
            }
            ?>
            <div class="container">
                <div class="profile-details">
                    <?php if ($edit_before) { ?>
                        <form action="admin_profile.php" method="post" enctype="multipart/form-data">
                            <div class="img-container">
                                <img src="developerpic/<?php echo $profile_img ?>" alt="<?php echo $full_name ?>"
                                    class="profile-image">
                            </div>
                            <div class="input-fields">
                                <h1> <strong>Full Name: </strong> <?php echo $full_name ?></h1>
                                <p><strong>Username:</strong> <?php echo $username ?></p>
                                <p><strong>Email:</strong> <?php echo $email ?></p>
                                <p><strong>Phone:</strong> <?php echo $phone ?></p>
                                <input type="hidden" name="admin_id" value="<?php echo $admin_id ?>">
                                <input type="hidden" name="profile_pic" value="<?php echo $profile_img ?>">
                                <div class="update-btn">
                                    <input type="submit" value="Edit Profile" name="edit_profile" class="btn">
                                    <input type="submit" value="Change Password" name="change_password" class="btn">
                                </div>

                            </div>
                        </form>
                    <?php }
                    if ($change_password) { ?>
                        <form action="admin_profile.php" method="POST" enctype="multipart/form-data">
                            <div class="img-container">
                                <img src="developerpic/<?php echo $profile_img ?>" alt="<?php echo $full_name ?>"
                                    class="profile-image">
                            </div>
                            <div class="input-fields change-pass">
                                <p><label for="old_passowrd">Enter Old Password</label> <input type="password"
                                        name="old_password" placeholder="Old Password" required></p>
                                <p><label for="new_password">Enter New Password</label> <input type="password"
                                        name="new_password" placeholder="New Password" required></p>
                                <p><label for="confirm_new_password">Confirm New Password</label> <input type="password"
                                        name="confirm_new_password" placeholder="Confirm New Password" required></p>
                                <input type="hidden" name="admin_id" value="<?php echo $admin_id ?>">
                                <input type="submit" value="Update Password" name="update_password" class="btn">
                                <a href="admin_profile.php" class="pass-btn-can">Cancel</a>
                            </div>
                        </form>

                    <?php }
                    if ($edit_after) { ?>
                        <form action="admin_profile.php" method="post" enctype="multipart/form-data">
                            <div class="img-container">
                                <img src="developerpic/<?php echo $profile_img ?>" alt="<?php echo $full_name ?>"
                                    class="profile-image">
                                <input type="file" name="profile_pic" id="">
                            </div>
                            <div class="input-fields">
                                <h1> <strong>Full Name:<input type="text" name="full_name" value="<?php echo $full_name ?>">
                                    </strong> </h1>
                                <p><strong>Username:</strong> <input type="text" name="username"
                                        value="<?php echo $username ?>"> </p>
                                <p><strong>Email:</strong> <input type="text" name="email" value="<?php echo $email ?>"></p>
                                <p><strong>Phone:</strong> <input type="text" name="phone" value="<?php echo $phone ?>"></p>
                                <input type="hidden" name="admin_id" value="<?php echo $admin_id ?>">
                                <div class="update-btn">
                                    <input type="submit" value="Update" name="update" class="btn">
                                    <input type="submit" value="cancel" name="update_cancel" class="cancel-btn">
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>





    </section>
    <!-- CONTENT -->






</body>

</html>