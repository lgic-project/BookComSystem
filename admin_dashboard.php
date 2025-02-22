<?php
session_start();
if (!isset($_SESSION['username']) && !$_SESSION['login_success']) {
  header(" Location: admin_login.php");
  exit();
}

require_once './connection/config.php';


$sql = "SELECT id, title, author, price, book_img  FROM books ORDER BY RAND() LIMIT 5";
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
      position:relative;
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

    .nav-link-2 i{
      width: 36px;
      height: 36px;
      object-fit: cover;
      border-radius: 50%;
      
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
    <div id="main-content">
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
              <p>by <?php htmlspecialchars($row['author']) ?> </p>
              <p class="price">$ <?php echo htmlspecialchars($row['price']) ?> </p>
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
    </div>

  </section>
  <!-- CONTENT -->





</body>

</html>