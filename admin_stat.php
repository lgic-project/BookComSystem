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
if ($result) {
    $row = $result->fetch_assoc();
    $total_sales = $row['total_sales'];
} else {
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


// select the order status

$result = $mysqli->query("SELECT status, COUNT(*) AS count FROM orders WHERE status IN ('Pending', 'Completed', 'Cancelled') GROUP BY status");
if ($result) {
    // Initialize counts
    $counts = [
        'Pending' => 0,
        'Completed' => 0,
        'Cancelled' => 0
    ];

    // Fetch results
    while ($row = $result->fetch_assoc()) {
        if ($row['status'] === 'Pending') {
            $counts['Pending'] = $row['count'];
        } elseif ($row['status'] === 'Completed') {
            $counts['Completed'] = $row['count'];
        } elseif ($row['status'] === 'Cancelled') {
            $counts['Cancelled'] = $row['count'];
        }
    }

    // Assign to variables for easier usage
    $order_pending = $counts['Pending'];
    $order_completed = $counts['Completed'];
    $order_cancelled = $counts['Cancelled'];

} else {
    echo "Error: " . $mysqli->error;
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
        :root {
            --main-color: #4b49AC;
            --second-color: #98BDFF;
            --light-blue: #7DA0FA;
            --light-purple: #7978E9;
            --light-red: #F3797E;
        }

        .error {
            background: #4b49ac;
            color: white;
            margin: 8px;
            padding: 7px;
            border-radius: 10px;
        }

        .sales,
        .order {
            display: flex;
            flex-direction: column;
        }

        .sales .boxes, .order .boxes{
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            
        }

        .box {
            width: 15rem;
            height: 10rem;
            border: 3px solid var(--main-color);
            border-radius: 20px;
            background: var(--second-color);
            padding: 20px;
            gap: 20px;
            font-size: xx-large;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>

<body>


    <!-- SIDEBAR -->
    <?php include 'admin_sidebar.php' ?>;
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
                    <h2>Sales</h2>
                    <div class="boxes">
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
                </div>
                <div class="order">
                    <h2>Orders</h2>
                    <div class="boxes">
                        <div class="box">
                            <h4>Pending</h4>
                            <p><?php echo $order_pending ?> </p>
                        </div>
                        <div class="box">
                            <h4>Completed</h4>
                            <p><?php echo $order_completed ?> </p>
                        </div>
                        <div class="box">
                            <h4>Cancelled</h4>
                            <p><?php echo $order_cancelled ?> </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>
    <!-- CONTENT -->





</body>

</html>