<?php
session_start();
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


if (isset($_POST['edit_profile'])) {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];


    $stmt = $mysqli->prepare("UPDATE admin SET username=?, full_name=?, email=?, phone_number=? WHERE admin_id=?");
    $stmt->bind_param('ssssi', $username, $full_name, $email, $phone, $admin_id);

    $stmt->execute();
    $stmt->close();

    header('Location: admin_profile.php');
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
        justify-content: center;
    }

    .container {
        margin-top: 100px;
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

    .container .profile-details form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    form label {
        font: bold 16px/1.5 sans-serif;

    }

    form input {
        width: 250px;
        height: 35px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    

    .profile-details .btn {
        width: 100px;
        height: 40px;
        padding: 10px 20px;
        background-color: #98BDFF;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .profile-details .btn:hover {
        background-color: #4b49AC;
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

            <a href="#" class="nav-link">Admin Dashboard</a>
            <div class="nav-link-2">
                <a href="#" class="profile">
                    <img src="img/people.png">
                </a>
            </div>
        </nav>
        <!-- NAVBAR -->

        <div class="profile-container" id="main-content">
            <div class="container">
                <div class="img-container">
                    <img src="developerpic/deepak.jpg" alt="profile" class="profile-image">
                </div>

                <div class="profile-details">
                    <form action="admin_editprofile.php" method="post" accept="multipart/form-data">
                        <div class="form-group">
                            <label for="full_name">Full Name :</label>
                            <input type="text" name="full_name" value="<?php echo $full_name ?>"
                                placeholder="Full Name">
                        </div>
                        <div class="form-group">
                            <label for="username">Username :</label>
                            <input type="text" name="username" value="<?php echo $username ?>" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label for="email">Email :</label>
                            <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>"
                                placeholder="email">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone :</label>
                            <input type="text" name="phone" value="<?php echo $phone ?>" placeholder="Phone">
                        </div>
                        <input type="hidden" name="admin_id" value="<?php echo $admin_id ?>">
                        <input type="submit" value="edit_profile" name="edit_profile" class="btn">
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- CONTENT -->






</body>

</html>