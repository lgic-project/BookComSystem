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
  $pages = trim($_POST['pages']);
  $pub_year = trim($_POST['pub_year']);
  $isbn = $_POST['isbn'];
  $publisher = trim($_POST['publisher']);
  $price = trim($_POST['price']);
  $category = trim($_POST['category']);
  $book_description = trim($_POST['description']);
  $stock = $_POST['stock'];
  $bookfile_name = basename($_FILES["book_image"]["name"]);

  if (!file_exists('bookspic')) {
    mkdir('bookspic', 0777, true);
  }

  if (empty($title) || empty($author) || empty($genre) || empty($pub_year) || empty($isbn) || empty($publisher) || empty($price) || empty($bookfile_name) || empty($stock)) {
    header("Location: admin_add_book?error=empty_fields");
    exit();
  }

  $target_dir = "bookspic/";
  $file_extension = strtolower(pathinfo($bookfile_name, PATHINFO_EXTENSION));
  $new_book_img = uniqid() . '.' . $file_extension; // Generate unique filename
  $target_file = $target_dir . $new_book_img;

  // Check if image file is actual image
  $check = getimagesize($_FILES["book_image"]["tmp_name"]);
  if ($check === false) {
    header("Location: admin_add_book.php?error=img_upl_err");
    exit();
  }

  // Allow certain file formats
  if ($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif") {
    header("Location: admin_add_book.php?error=not_suitable_img_format");
    exit();
  }



  $sql = "SELECT id FROM books WHERE title=?";
  if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("s", $title);

    if ($stmt->execute()) {
      $stmt->store_result();
      if ($stmt->num_rows > 0) {
        echo "add error";
        header("Location: admin_add_book.php?error=books_already_in_store");
        exit();
      }
    }
  }
  $stmt;
  // inserting book in the database
  // first we need to uplaod file
  if (move_uploaded_file($_FILES["book_image"]["tmp_name"], $target_file)) {
    if ($stmt = $mysqli->prepare("INSERT  INTO books(title, author, genre,pages, book_description,  pub_year, isbn, publisher, price, stock, book_img ) VAlUES (?, ?, ?,?,?,?, ?, ?, ?, ?, ?)")) {
      $stmt->bind_param("sssisissdis", $title, $author, $genre, $pages, $book_description, $pub_year, $isbn, $publisher, $price, $stock, $new_book_img);
      if ($stmt->execute()) {
        $stmt->store_result();
        header("Location: admin_add_book.php?add_book=success");
        $stmt->close();
        exit();
      } else {
        header("Location: admin_add_book.php?add_book=Book_add_fail");
        $stmt->close();
        exit();
      }
    }
  }
}

// login error get 
$error = '';
if (isset($_GET['error'])) {
  switch ($_GET['error']) {
    case 'img_upl_err':
      $error = "Image Upload Error! Use Smaller size";
      break;
    case 'not_suitable_img_format':
      $error = "Not Suitable Image format ";
      break;
    case 'books_already_in_store':
      $error = "Alread in Store! Please Add new Book";
      break;
    case 'empty_fields':
      $error = "All fields are required!";
      break;
    default:
      $error = "";
      break;
  }
}

//msg when book added
if (isset($_GET['add_book'])) {
  switch ($_GET['add_book']) {
    case 'success':
      $error = "Successfully Book Added";
      break;
    case 'Book_add_fail':
      $error = "Error While Adding Book in Store";
      break;
    default:
      $error = "";
      break;
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
  <link rel="stylesheet" href="./css/admin_add_book.css">

  <title>Dashboard Admin: <?php echo $username ?> </title>
  <style>
    .error {
      background: #4b49ac;
      color: white;
      margin: 8px;
      padding: 7px;
      border-radius: 10px;
    }

    .btn-submit {
      margin-left: 40px;
      margin-top: -40px;
      background: #4b49ac;
      height: 50px;
      width: 150px;
      padding: 10px 20px;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn-submit:hover {
      background: green !important;
      ;
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
      <a href="#" class="nav-link">Admin Dashboard : Add Book</a>
      <div class="nav-link-2">
        <a href="admin_profile.php" class="profile">
          <img src="img/people.png">
        </a>
      </div>
    </nav>
    <!-- NAVBAR -->
    <!--MAIN CONTENT -->
    <div class="addbook-container" id="main-content">
      <h2>
        <?php
        if ($error) {
          echo "<div class='error'> $error </div>";
        }
        ?>
      </h2>
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

        <!-- Page -->
        <div class="input-group">
          <label for="pages">Pages:</label>
          <input type="number" id="pages" name="pages" min="1" required>
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

        <!-- category -->
        <div class="input-group">
          <label for="category">Category:</label>
          <input type="text" id="category" name="category" required>
        </div>

        <!-- Price -->
        <div class="input-group">
          <label for="price">Price:</label>
          <input type="number" id="price" name="price" step="1" min="0">
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

        <!--description -->
        <div class="input-group">
          <label for="description">Description:</label>
          <textarea id="description" name="description" rows="5" cols="60"></textarea>
        </div>

        <!-- Submit Button -->
        <button class="btn-submit" type="submit">Add Book</button>
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