<?php
$_SESSION['username'] = "Deepak";
$username = $_SESSION['username'];

require_once './connection/config.php';


$sql = "SELECT id, title, author, price, book_img  FROM books";
$result = $mysqli->query($sql);

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

    /* Profile Container */
    .profile-container {
        display: flex;
    }

    /* Left Section */
    .profile-left {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid white;
        object-fit: cover;
    }

    /* Right Section */
    .profile-right {
        flex: 2;
        padding: 20px;
    }

    .profile-right h1 {
        margin-top: 0;
        color: #2c3e50;
    }

    .profile-right p {
        margin: 10px 0;
        line-height: 1.6;
    }

    .profile-right strong {
        color: #3498db;
    }
</style>

<body>


    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">Bookly</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="admin_dashboard.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="admin_add_book.php">
                    <i class='bx bxs-file-plus'></i>
                    <span class="text">Add Book</span>
                </a>
            </li>
            <li>
                <a href="admin_searchbooks.php">
                    <i class='bx bx-search-alt-2'></i>
                    <span class="text">Search Book</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bxs-folder-minus'></i>
                    <span class="text">Delete Book</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bxs-group'></i>
                    <span class="text">Order</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-line-chart'></i>
                    <span class="text">Report</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#">
                    <i class='bx bx-user-circle'></i>
                    <span class="text">Profile</span>
                </a>
            </li>
            <li>
                <a href="#" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
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
            <div class="profile-left">
                <img src="profile.jpg" alt="Profile Picture" class="profile-image">
            </div>
            <div class="profile-right">
                <h1>John Doe</h1>
                <p><strong>Email:</strong> johndoe@example.com</p>
                <p><strong>Phone:</strong> +123 456 7890</p>
                <p><strong>Address:</strong> 123 Main Street, Anytown, USA</p>
                <p><strong>About Me:</strong> A passionate developer with experience in web technologies.</p>
            </div>
        </div>





    </section>
    <!-- CONTENT -->






</body>

</html>