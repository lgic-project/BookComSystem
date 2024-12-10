<?php
include_once './connection/config.php';

$book_title = htmlspecialchars($_GET['book_title']);

$sql = "SELECT * FROM books WHERE title = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('s', $book_title);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();


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
            <h1>Edit Book Details</h1>

            <form action="admin_editbook.php" method="POST" class="form-group">
                <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">


                <div class="input-group">
                    <label for="title">Book Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>">
                </div>
                <div class="input-group">
                    <label for="author">Author:</label>
                    <input type="text" id="author" name="author"
                        value="<?php echo htmlspecialchars($book['author']); ?>">
                </div>
                <div class="input-group">
                    <label for="genre">genre:</label>
                    <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($book['genre']); ?>">
                </div>
                <div class="input-group">
                    <label for="pub_year">Published year:</label>
                    <input type="text" id="pub_year" name="pub_year"
                        value="<?php echo htmlspecialchars($book['pub_year']); ?>">
                </div>
                <div class="input-group">
                    <label for="isbn">isbn:</label>
                    <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>">
                </div>
                <div class="input-group">
                    <label for="publisher">Publisher:</label>
                    <input type=" text" id="publisher" name="publisher"
                        value="<?php echo htmlspecialchars($book['publisher']); ?>">
                </div>


                <div class="input-group">
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price"
                        value="<?php echo htmlspecialchars($book['price']); ?>">
                </div>


                <div class="input-group">
                    <label for="stock">stock:</label>
                    <input type="number" id="stock" name="stock"
                        value="<?php echo htmlspecialchars($book['stock']); ?>">
                </div>
                <input type="submit" name="edit_book" style="width: 8rem; height: 3rem;" value="Update Book">
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