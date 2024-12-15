<?php


require_once './connection/config.php';
$error = "";

//for fetching the count of the books
$result = $mysqli->query("SELECT COUNT(id) AS total_rows FROM books");
if ($result) {
    $row = $result->fetch_assoc();
    $book_count = $row['total_rows'];

    echo "Total rows: " . $book_count;
} else {
    $book_count = 0;
}

// fetching the completed order which represents the total sales
$result = $mysqli->query("SELECT sum(total_price) AS total_sales FROM orders WHERE status = 'Completed'");
if($result){
    $row = $result-> fetch_assoc();
    $total_sales = $row['total_sales'];
}else{
    $total_sales = 0;
}

// count the books quantity 
$result = $mysqli->query("SELECT sum(stock) AS total_quantity FROM books");
if ($result) {
    $row = $result->fetch_assoc();
    $book_quantities = $row['total_quantity'];

} else {
    $book_quantities = 0;
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


    <!-- fro erro handling -->
    <style>
        .error {
            background: #4b49ac;
            color: white;
            margin: 8px;
            padding: 7px;
            border-radius: 10px;
        }
    </style>
</head>

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
                <a href="admin_orderprocess.php">
                    <i class='bx bxs-group'></i>
                    <span class="text">Order</span>
                </a>
            </li>
            <li>
                <a href="admin_stat.php">
                    <i class='bx bx-line-chart'></i>
                    <span class="text">Report</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="admin_profilecard.php">
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

            <a href="admin_dashboard.php" class="nav-link">Admin Dashboard</a>
            <div class="nav-link-2">
                <a href="admin_profilecard.php" class="profile">
                    <img src="img/people.png">
                </a>
            </div>
        </nav>
        <!-- NAVBAR -->
        <div id="main-content">
            <h2>
                <?php
                if ($error) {
                    echo "<div class='error'> $error </div>";
                    
                }
                ?>
            </h2>
            <h2> Overview</h2>
            <div class="overview">
                <div class="sales">
                    <div class="box">
                        <h4>Total sales</h4>
                        <p><?php echo $total_sales; ?></p>
                    </div>
                    <div class="box">
                        <h4>Books </h4>
                        <p> <?php echo $book_count; ?></p>
                    </div>
                    <div class="box">
                        <h4>Books Quantity</h4>
                        <p><?php echo $book_quantities ?></p>
                    </div>
                </div>
                <div class="order">
                    <div class="box"></div>
                    <div class="box"></div>
                    <div class="box"></div>
                </div>

            </div>

        </div>

    </section>
    <!-- CONTENT -->





</body>

</html>