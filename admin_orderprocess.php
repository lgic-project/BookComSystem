<?php

session_start();
if (!isset($_SESSION['username']) && !$_SESSION['loggedin']) {
    header(" Location: admin_login.php");
    exit();
}



//show the order different status
$order_cancelled_table = false;
$order_completed_table = false;
$order_pending_table = false;

if ($_SESSION['loggedin']=== true) {
    $order_pending_table = true;
}
//database connection
include_once './connection/config.php';

// Fetch orders from the database
$sql = "SELECT o.id, o.order_date, o.status, o.total_price, u.username, u.email, o.address, o.phone_no
        FROM orders o 
        JOIN users u ON o.user_id = u.id";
$result = $mysqli->query($sql);

$username = $_SESSION['username'];


// Handle status update
if (isset($_POST['status'])) {
    // var_dump(  $_POST);
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $stmt = $mysqli->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        header("Location:admin_orderprocess.php?book_order=" . urldecode($status) . "");
        exit();
    } else {
        echo "<p>Error updating order: " . $mysqli->error . "</p>";
    }
}





if (isset($_POST['book_order'])) {
    $book_order = $_POST['book_order'];
    if ($book_order === "Pending") {
        $order_pending_table = true;
    } elseif ($book_order === "Completed") {
        $order_completed_table = true;
    } elseif ($book_order === "Cancelled") {
        $order_cancelled_table = true;
    }
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
    <style>
        .o-process-section {
            display: flex;
            justify-content: space-between;
        }

        .order-processed {
            display: flex;
            justify-content: space-around;
            gap: 20px;
            margin-right: 10rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }

        .status-btn {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            cursor: pointer;
        }

        .btn-processing {
            background-color: #ffc107;
            color: #fff;
        }

        .btn-completed {
            background-color: #28a745;
            color: #fff;
        }

        .btn-cancelled {
            background-color: #dc3545;
            color: #fff;
        }

        .status-btn1 {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            cursor: pointer;
            background-color: #7DA0FA;
            color: white;
        }

        .status-btn1:hover {
            background-color: #4b49ac;
            color: #98BDFF;
        }
    </style>

    <title>Dashboard Admin: <?php echo $username ?> </title>
</head>

<body>


    <!-- SIDEBAR -->
    <?php include_once 'admin_sidebar.php' ?>;
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
        <div id="main-content">

            <body>
                <div class="o-process-section">
                    <h1>Admin Order Management</h1>
                    <div class="order-processed">
                        <form action="admin_orderprocess.php" method="POST" style="display:inline;">
                            <button class="status-btn1 btn-processing1" name="book_order"
                                value="Pending">Pending</button>
                            <button class="status-btn1 btn-completed1" name="book_order"
                                value="Completed">Completed</button>
                            <button class="status-btn1 btn-cancelled1" name="book_order"
                                value="Cancelled">Cancelled</button>
                        </form>
                    </div>
                </div>

                <!-- Orders Table -->
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Order items</th>
                            <th>Address</th>
                            <th>Phone No.</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Total Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <?php if ($row['status'] === "Pending" && $order_pending_table): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['username']; ?> (<?php echo $row['email']; ?>)</td>
                                        <td>
                                            <?php
                                            $sql = "SELECT * FROM order_items o WHERE order_id =" . (int) $row['id'];
                                            $result1 = $mysqli->query($sql);
                                            if ($result1->num_rows > 0) {
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    $sql = "SELECT * FROM books WHERE id =" . (int) $row1['product_id'];
                                                    $result2 = $mysqli->query($sql);
                                                    if ($result2->num_rows > 0) {
                                                        while ($row2 = $result2->fetch_assoc()) {
                                                            echo $row2['title'] . "(" . $row1['quantity'] . ") :" . $row2['price'] . "<br>";

                                                        }
                                                    }
                                                }
                                                $result2->close();
                                                $result1->close();

                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $row['address']; ?></td>
                                        <td><?php echo $row['phone_no']; ?></td>
                                        <td><?php echo $row['order_date']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td>Rs.<?php echo number_format($row['total_price'], 2); ?></td>
                                        <td>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                                <button class="status-btn btn-processing" name="status"
                                                    value="Pending">Pending</button>
                                                <button class="status-btn btn-completed" name="status"
                                                    value="Completed">Completed</button>
                                                <button class="status-btn btn-cancelled" name="status"
                                                    value="Cancelled">Cancelled</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php elseif ($row['status'] === "Completed" && $order_completed_table): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['username']; ?> (<?php echo $row['email']; ?>)</td>
                                        <td>
                                            <?php
                                            $sql = "SELECT * FROM order_items o WHERE order_id =" . (int) $row['id'];
                                            $result1 = $mysqli->query($sql);
                                            if ($result1->num_rows > 0) {
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    $sql = "SELECT * FROM books WHERE id =" . (int) $row1['product_id'];
                                                    $result2 = $mysqli->query($sql);
                                                    if ($result2->num_rows > 0) {
                                                        while ($row2 = $result2->fetch_assoc()) {
                                                            echo $row2['title'] . "(" . $row1['quantity'] . ") :" . $row2['price'] . "<br>";

                                                        }
                                                    }
                                                }
                                                $result2->close();
                                                $result1->close();

                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $row['address']; ?></td>
                                        <td><?php echo $row['phone_no']; ?></td>
                                        <td><?php echo $row['order_date']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td>Rs.<?php echo number_format($row['total_price'], 2); ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                    </tr>
                                <?php elseif ($row['status'] === "Cancelled" && $order_cancelled_table): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['username']; ?> (<?php echo $row['email']; ?>)</td>
                                        <td>
                                            <?php
                                            $sql = "SELECT * FROM order_items o WHERE order_id =" . (int) $row['id'];
                                            $result1 = $mysqli->query($sql);
                                            if ($result1->num_rows > 0) {
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    $sql = "SELECT * FROM books WHERE id =" . (int) $row1['product_id'];
                                                    $result2 = $mysqli->query($sql);
                                                    if ($result2->num_rows > 0) {
                                                        while ($row2 = $result2->fetch_assoc()) {
                                                            echo $row2['title'] . "(" . $row1['quantity'] . ") :" . $row2['price'] . "<br>";

                                                        }
                                                    }
                                                }
                                                $result2->close();
                                                $result1->close();

                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $row['address']; ?></td>
                                        <td><?php echo $row['phone_no']; ?></td>
                                        <td><?php echo $row['order_date']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td>Rs.<?php echo number_format($row['total_price'], 2); ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">No orders found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>



        </div>



    </section>
    <!-- CONTENT -->




    <script>
        const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

        allSideMenu.forEach(item => {
            const li = item.parentElement;

            item.addEventListener('click', function () {
                allSideMenu.forEach(i => {
                    i.parentElement.classList.remove('active');
                })
                li.classList.add('active');
            })
        });


    </script>
</body>

</html>