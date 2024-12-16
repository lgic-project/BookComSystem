<?php
//database connection
include_once './connection/config.php';

// Fetch orders from the database
$sql = "SELECT o.id, o.order_date, o.status, o.total_price, u.username, u.email 
        FROM orders o 
        JOIN users u ON o.user_id = u.id";
$result = $mysqli->query($sql);

$_SESSION['username'] = "Deepak";
$username = $_SESSION['username'];

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
    </style>

    <title>Dashboard Admin: <?php echo $username ?> </title>
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
        <div id="main-content">

            <body>
                <h1>Admin Order Management</h1>

                <!-- Orders Table -->
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Total Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()):
                                if (($row['status'] === "Pending")) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['username']; ?> (<?php echo $row['email']; ?>)</td>
                                        <td><?php echo $row['order_date']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td>$<?php echo number_format($row['total_price'], 2); ?></td>
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
                                <?php }endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No orders found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php
                // Handle status update
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $order_id = $_POST['order_id'];
                    $status = $_POST['status'];

                    $update_sql = "UPDATE orders SET status = ? WHERE id = ?";
                    $stmt = $mysqli->prepare($update_sql);
                    $stmt->bind_param("si", $status, $order_id);

                    if ($stmt->execute()) {
                        header("Location:admin_orderprocess.php?book_order={$status}");
                    } else {
                        echo "<p>Error updating order: " . $mysqli->error . "</p>";
                    }
                }

                // Close connection
                $mysqli->close();
                ?>

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