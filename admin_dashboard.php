<?php


require_once './connection/config.php';


$sql = "SELECT id, title, author, price, book_img  FROM books";
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
      margin-bottom: 10px;
    }

    .edit-button {
      padding: 8px;
      color: white;
      background: purple;
      border: 2px solid wheat;
      border-radius: 7px;
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
      if($error){
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
              <p>by <?php htmlspecialchars($row['author']) ?> </p>
              <p class="price">$ <?php echo htmlspecialchars($row['price']) ?> </p>
              <form method="POST" action="admin_delbook.php" name="delbook">
                <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($row['id']) ?> ">
                <input type="hidden" name="book_title" value="<?php echo htmlspecialchars($row['title']) ?> ">
                <button type="submit" name="delete">Delete</button>
              </form>
            </div>
            <?php
          }
        } else {
          echo '<p>No books found</p>';
        }
        ?>
      </div>
    </div>

  </section>
  <!-- CONTENT -->





</body>

</html>