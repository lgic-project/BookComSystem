<?php

if (!isset($_SESSION['username']) && !$_SESSION['login_success']) {
    header(" Location: admin_login.php");
    exit();
}
$username = $_SESSION['username'];

require_once './connection/config.php';


$sql = "SELECT id, title, author, price, book_img  FROM books";
$result = $mysqli->query($sql);

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
        .search-container h2 {
            margin: 10px 5px 20px 5px;
            text-align: center;
            font-size: 30px;
            color: purple;
        }

        .search-container .form-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            font-size: larger;
        }



        .search-container .form-group input[type='submit'] {
            padding: 3px;
        }

        .search-container h3 {
            margin-left: 3rem;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 20px;
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
</head>

<body>


    <!-- SIDEBAR -->
    <?php include 'admin_sidebar.php' ?>;
    <!-- SIDEBAR -->



    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <a href="#" class="nav-link">Admin Dashboard : Booklist </a>
            <div class="nav-link-2">
                <a href="admin_profile.php" class="profile">
                    
                </a>
            </div>
        </nav>
        <!-- NAVBAR -->

        <div class="grid-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <div class="grid-item">
                        <img src="./bookspic/<?php echo htmlspecialchars($row['book_img']); ?>"
                            alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p>by <?php echo htmlspecialchars($row['author']); ?></p>
                        <p class="price">$<?php echo htmlspecialchars($row['price']); ?></p>
                        <form method="POST" action="admin_delbook.php" name="delbook">
                            <input type="hidden" name="book_title" value="<?php echo htmlspecialchars($row['title']); ?>">
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