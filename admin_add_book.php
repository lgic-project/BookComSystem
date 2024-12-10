<?php
// if (!isset($_SESSION['username']) && !$_SESSION['login_success']) {
//     header(" Location: login.php");
//     exit();
// }

include './connection/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $genre = trim($_POST['genre']);
    $pub_year = trim($_POST['pub_year']);
    $isbn = $_POST['isbn'];
    $publisher = trim($_POST['publisher']);
    $price = trim($_POST['price']);
    $stock = $_POST['stock'];
    $bookfile_name = basename($_FILES["book_image"]["name"]);

    if (!file_exists('bookspic')) {
        mkdir('bookspic', 0777, true);
    }

    $target_dir = "bookspic/";
    $file_extension = strtolower(pathinfo($bookfile_name, PATHINFO_EXTENSION));
    $new_book_img = uniqid() . '.' . $file_extension; // Generate unique filename
    $target_file = $target_dir . $new_book_img;

    // Check if image file is actual image
    $check = getimagesize($_FILES["book_image"]["tmp_name"]);
    if ($check === false) {
        header("Location: dashboard.php?upload=error");
        exit();
    }

    // Allow certain file formats
    if ($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif") {
        header("Location: dashboard.php?upload=error");
        exit();
    }



    $sql = "SELECT id FROM books WHERE title=?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $title);

        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                echo "add error";
                header("Location: .php?error=books_already_in_store");
                exit();
            }
        }
    }
    $stmt;
    // inserting book in the database
    // first we need to uplaod file
    if (move_uploaded_file($_FILES["book_image"]["tmp_name"], $target_file)) {
    if ($stmt = $mysqli->prepare("INSERT  INTO books(title, author, genre, pub_year, isbn, publisher, price, stock, book_img ) VAlUES (?, ?, ?, ?, ?, ?, ?, ?,?)")) {
        $stmt->bind_param("sssissdis", $title, $author, $genre, $pub_year, $isbn, $publisher, $price, $stock, $new_book_img);
        if ($stmt->execute()) {
            $stmt->store_result();
            echo "book added into database";
            header("Location: admin_add_book.php?add_book=success");
            $stmt->close();
            exit();
        } else {
            header("Location: admin_add_book.php?add_book= Book_add_fail");
            $stmt->close();
            exit();
        }
    }
}
}


?>

<?php
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
  <link rel="stylesheet" href="./css/bookform.css">

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
  <div class="addbook-container">
  <h1>Enter Book Details</h1>
    <form action="admin_add_book.php" method="POST" enctype="multipart/form-data" class="form-group">
        <div class="input-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        </div>

        <!-- Author -->
         <div class="input-group">
        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required>
        </div>

        <!-- Genre -->
         <div class="input-group">
        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre">
        </div>

        <!-- Publication Year -->
         <div class="input-group">
        <label for="pub_year">Publication Year:</label>
        <input type="number" id="pub_year" name="pub_year" min="1000" max="9999">
        </div>

        <!-- ISBN -->
         <div class="input-group">
        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" required>
        </div>

        <!-- Publisher -->
         <div class="input-group">
        <label for="publisher">Publisher:</label>
        <input type="text" id="publisher" name="publisher">
        </div>

        <!-- Price -->
         <div class="input-group">
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" min="0">
        </div>

        <!-- Stock -->
         <div class="input-group">
        <label for="stock">Stock Quantity:</label>
        <input type="number" id="stock" name="stock" min="0" step="1">
        </div>

        <!-- Image -->
         <div class="input-group">
        <label for="img">Book Cover Image:</label>
        <input type="file" name="book_image" id="book_image" accept="bookspic/" required>
        </div>

        <!-- Submit Button -->
        <button type="submit">Add Book</button>
    </form>
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