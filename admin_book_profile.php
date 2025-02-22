<?php
require_once './connection/config.php';

if (!isset($_SESSION['username']) && !$_SESSION['login_success']) {
  header(" Location: admin_login.php");
  exit();
}
if (isset($_GET['book_id'])) {
  $book_id = intval($_GET['book_id']);

  $sql = "SELECT *  FROM books where id = $book_id";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();

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

  <!--style book details -->
  <style>
    .book-details-container {
      display: flex;
      max-width: 1000px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .book-image {
      flex: 1;
      padding-right: 20px;
    }

    .book-image img {
      width: 100%;
      max-width: 250px;
      border-radius: 10px;
    }

    .book-details {
      margin-left: 10px;
      flex: 2;
    }

    .book-details p {
      margin: 10px;
    }

    h2 {
      margin: 0 0 10px;
      color: #333;
    }

    .price {
      font-size: 18px;
      color: green;
      font-weight: bold;
    }

    .b-button {
      position: absolute;
      margin-bottom: 5px;
      bottom: 20px;
      background-color: purple;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    .b-button:hover {
      background: purple;
      color: white;
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
</head>

<body>


  <!-- SIDEBAR -->
  <?php include 'admin_sidebar.php' ?>
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
      <div class="book-container">
        <div class="book-heading">
          <h3><?php echo $row['title'] ?></h3>
        </div>
        <div class="book-details-container">
          <div class="book-image">
            <img src="./bookspic/<?php echo $row['book_img']; ?>" alt="Book Cover">
          </div>
          <div class="book-details">
            <h2><?php echo htmlspecialchars($row['title']); ?></h2>
            <p><strong>Author:</strong> <?php echo htmlspecialchars($row['author']); ?></p>
            <p><strong>Genre:</strong> <?php echo htmlspecialchars($row['genre']); ?></p>
            <p><strong>Pages:</strong> <?php echo htmlspecialchars($row['pages']); ?></p>
            <p><strong>Publication Year:</strong> <?php echo htmlspecialchars($row['pub_year']); ?></p>
            <p><strong>ISBN:</strong> <?php echo htmlspecialchars($row['isbn']); ?></p>
            <p><strong>Publisher:</strong> <?php echo htmlspecialchars($row['publisher']); ?></p>
            <p><strong>Stock:</strong> <?php echo htmlspecialchars($row['stock']); ?></p>

            <p class="price">Price: $<?php echo number_format($row['price'], 2); ?></p>
            <p><?php echo htmlspecialchars($row['book_description']); ?></p>

            <a class='b-button' href='  admin_editbooks.php?book_title=<?php echo $row['title'] ?>'>Edit</a>
          </div>

        </div>
      </div>
    </div>

  </section>
  <!-- CONTENT -->


</body>

</html>