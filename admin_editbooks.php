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
    <link rel="stylesheet" href="./css/admin_add_book.css">
    <title>Dashboard Admin: <?php echo $username ?> </title>
</head>
<style>
    .input-group #description {
        padding: 5px;
    }

    .btn-submit {
        margin-top: 20px;
        margin-left: 40px;
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
    }
</style>

<body>


    <!-- SIDEBAR -->
    <?php include 'admin_sidebar.php' ?>;
    <!-- SIDEBAR -->



    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <a href="#" class="nav-link">Admin Dashboard : Edit Book</a>
            <div class="nav-link-2">
                <a href="admin_profile.php" class="profile">
                    <img src="img/people.png">
                </a>
            </div>
        </nav>
        <!-- NAVBAR -->
        <div class="addbook-container" id="main-content">
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
                    <label for="pages">Pages:</label>
                    <input type="number" name="pages" id="pages" value="<?php echo htmlspecialchars($book['pages']) ?>"
                        min="1" required>
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
                    <input type="text" id="publisher" name="publisher"
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

                <div class="input-group">
                    <label for="description">Description:</label>
                    <textarea type="text" id="description" name="book_description" rows="5" cols="60"></textarea>
                </div>
                <button class="btn-submit" type="submit" name="edit_book">Update</button>
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