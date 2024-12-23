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


if (isset($_POST['submit'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];


    $stmt = $mysqli->prepare("UPDATE admin SET username=?, full_name=?, email=?, phone_number=? WHERE admin_id=?");
    $stmt->bind_param('sssi', $full_name, $email, $phone, $admin_id);

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
                    <form action="">
                        <h1> <strong>Full Name: </strong> <?php echo $full_name ?></h1>
                        <p><strong>Username:</strong> <?php echo $username ?></p>
                        <p><strong>Email:</strong> <?php echo $email ?></p>
                        <p><strong>Phone:</strong> <?php echo $phone ?></p>
                        <input type="hidden" name="admin_id" value="<?php echo $admin_id ?>">
                        <input type="submit" value="Edit Profile" name="edit_profile" class="btn">
                    </form>
                </div>
            </div>
        </div>





    </section>
    <!-- CONTENT -->






</body>

</html>