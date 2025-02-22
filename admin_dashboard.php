<?php
session_start();
if (!isset($_SESSION['username']) && !$_SESSION['login_success']) {
  header(" Location: admin_login.php");
  exit();
}

require_once './connection/config.php';


$sql = "SELECT id, title, author, price, book_img  FROM books ORDER BY RAND() LIMIT 4";
$result = $mysqli->query($sql);


$error = "";
$book_title = "";
if (isset($_GET['delete_book'])) {
  $book_title = htmlspecialchars($_GET['book_name']);
  switch ($_GET['delete_book']) {
    case 'success':
      $error = "$book_title has been successfully removed";
      break;
    case 'unsuccess':
      $error = "$book_title fail to remove";
      break;
    default:
      $error = "";
      break;
  }
}


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
  if ($total_sales < 0) {
    $total_sales = 0;
  }
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
  <style>
    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
      gap: 20px;
      margin-left: 20px;
      padding: 20px;
    }

    .grid-item {
      border: 1px solid #ddd;
      border-radius: 8px;
      position: relative;
      overflow: hidden;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      text-align: center;
      padding: 10px;
      padding-bottom: 15px;
      margin: 15px 15px;
    }

    .grid-item img {
      width: 100%;
      height: auto;
    }

    .grid-item h3 {
      font-size: 18px;
      margin: 10px 10px;
    }

    .grid-item p {
      font-size: 14px;
      color: #555;
    }

    .grid-item .price {
      font-weight: bold;
      color: #000;
      margin-bottom: 30px;
    }

    .edit-button {
      padding: 8px;
      color: white;
      background: purple;
      border: 2px solid wheat;
      border-radius: 7px;
      margin-bottom: 10px;
      right: 10px;
      position: absolute;
      bottom: 0;
      align-items: center;
    }
  </style>

  <!-- fro erro handling -->
  <style>
    .error {
      background: #4b49ac;
      color: white;
      margin: 8px;
      padding: 7px;
      border-radius: 10px;
    }

    .nav-link-2 i {
      width: 36px;
      height: 36px;
      object-fit: cover;
      border-radius: 50%;

    }
  </style>
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
        <a href="admin_profile.php" class="profile">
          <i class='bx bxs-user-circle'></i>
        </a>
      </div>
    </nav>
    <!-- NAVBAR -->
    <div class="container">
      <!-- Error Message -->
      <?php if (!empty($error)) { ?>
        <div class="error-box"><?php echo $error; ?></div>
      <?php } ?>

      <h2 class="dashboard-title">📊 Report Overview</h2>

      <div class="dashboard">
        <!-- Sales Overview -->
        <div class="card sales">
          <h3>💰Toal Sales & 📚Book Overview</h3>
          <div class="stats">
            <div class="stat">
              <h4>Total Sales</h4>
              <p>Rs.<?php echo number_format((float) $total_sales, 2); ?></p>
            </div>
            <div class="stat">
              <h4>Total Books</h4>
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
    <!-- <div id="main-content">
      <h2>
        <?php
        if ($error) {
          echo "<div class='error'> $error </div>";
        }
        ?>
      </h2>
      <h2>Book Lists</h2>
      <div class="grid-container">

        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            ?>
            <div class="grid-item">
              <img src="./bookspic/<?php echo $row['book_img'] ?> " alt="<?php echo htmlspecialchars($row['title']) ?>">
              <h3> <?php echo htmlspecialchars($row['title']) ?> </h3>
              <p>by <?php echo htmlspecialchars($row['author']) ?> </p>
              <p class="price">Rs. <?php echo htmlspecialchars($row['price']) ?> </p>
              <form method="POST" action="admin_delbook.php" name="delbook">
                <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($row['id']) ?> ">
                <input type="hidden" name="book_title" value="<?php echo htmlspecialchars($row['title']) ?> ">
                <button type="submit" name="delete" class="edit-button">Delete</button>
              </form>
            </div>
            <?php
          }
        } else {
          echo '<p>No books found</p>';
        }
        ?>
      </div>
      <div class="add-button">
        <a href="admin_add_book.php" class="edit-button">Add Book</a>
      </div>
    </div> -->

  </section>
  <!-- CONTENT -->





</body>

</html>