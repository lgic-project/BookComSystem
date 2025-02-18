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
        /* Define Theme Colors */
:root {
    --main-color: #4b49AC;
    --second-color: #98BDFF;
    --light-blue: #7DA0FA;
    --light-purple: #7978E9;
    --light-red: #F3797E;
    --white: #fff;
    --text-dark: #333;
    --text-light: #555;
}

.container {
    margin-top: 30px;
    margin: 38px auto;
    max-width: 900px;
    padding: 20px;
    background: var(--white);
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

/* Error Message */
.error-box {
    background: var(--light-red);
    color: var(--white);
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 10px;
    text-align: center;
}

/* Dashboard Title */
.dashboard-title {
    text-align: center;
    font-size: 1.8rem;
    margin-bottom: 20px;
    color: var(--main-color);
}

/* Dashboard Layout */
.dashboard {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

/* Card Styles */
.card {
    flex: 1;
    background: var(--white);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
}

.card:hover {
    transform: scale(1.03);
}

/* Sales and Orders Specific Styling */
.sales {
    border-left: 5px solid var(--light-blue);
}

.orders {
    border-left: 5px solid var(--light-purple);
}

/* Statistics Styling */
.stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    text-align: center;
    margin-top: 10px;
}

.stat {
    background: var(--second-color);
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: 0.3s ease;
}

.stat:hover {
    background: var(--light-blue);
}

h3 {
    margin-bottom: 15px;
    text-align: center;
    color: var(--main-color);
}

h4 {
    margin-bottom: 5px;
    font-size: 1rem;
    color: var(--text-dark);
}

p {
    font-size: 1.2rem;
    font-weight: bold;
    color: var(--text-light);
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard {
        flex-direction: column;
    }
    
    .stats {
        grid-template-columns: 1fr;
    }
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
        <div class="container">
        <!-- Error Message -->
        <?php if (!empty($error)) { ?>
            <div class="error-box"><?php echo $error; ?></div>
        <?php } ?>

        <h2 class="dashboard-title">📊 Dashboard Overview</h2>

        <div class="dashboard">
            <!-- Sales Overview -->
            <div class="card sales">
                <h3>💰 Sales Overview</h3>
                <div class="stats">
                    <div class="stat">
                        <h4>Total Sales</h4>
                        <p>$<?php echo number_format($total_sales, 2); ?></p>
                    </div>
                    <div class="stat">
                        <h4>Books Sold</h4>
                        <p><?php echo $book_count; ?></p>
                    </div>
                    <div class="stat">
                        <h4>Books Quantity</h4>
                        <p><?php echo $book_quantities; ?></p>
                    </div>
                </div>
            </div>

            <!-- Orders Overview -->
            <div class="card orders">
                <h3>📦 Orders Overview</h3>
                <div class="stats">
                    <div class="stat">
                        <h4>Pending Orders</h4>
                        <p><?php echo $order_pending; ?></p>
                    </div>
                    <div class="stat">
                        <h4>Completed Orders</h4>
                        <p><?php echo $order_completed; ?></p>
                    </div>
                    <div class="stat">
                        <h4>Cancelled Orders</h4>
                        <p><?php echo $order_cancelled; ?></p>
                    </div>
                </div>
            </div>
        </div>

    </div>


    </section>
    <!-- CONTENT -->





</body>

</html>