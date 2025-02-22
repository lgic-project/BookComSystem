<?php
session_start();
include('./connection/config.php');
$msg_from_edit = "";
if (isset($_GET['bookedit'])) {
    if ($_GET['bookedit'] === 'success') {
        $msg_from_edit = "Successfully Book Edit";
    } elseif ($_GET['bookedit'] === 'unsuccess') {
        $msg_from_edit = "Book Edit Unsuccessful";
    } else {
        $msg_from_edit = "";
    }

}

//book qunatity update 
if (isset($_POST['book_stock_update'])) {
    $book_id = $_POST['book_id'];
    $new_quantity = $_POST['stock-input'];

    $sql = "UPDATE books SET stock = ? WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param('ii', $new_quantity, $book_id);
        if ($stmt->execute()) {
            $error = "Book Quantity Update Successful";
        } else {
            $error = "Book Quantity Update Failed";
        }
    }
}

$search_results = [];
$search_query = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    $search_query = $_GET['search'];

    // Search the database for books matching the title or author

    if ($stmt = $mysqli->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ?")) {
        $search_term = "%" . $search_query . "%"; // For partial matching
        $stmt->bind_param('ss', $search_term, $search_term);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the results into an array
        while ($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    } else {
        header("Location: admin_searchbooks.php?error=search_failed");
        exit();
    }
}
$error = "";
if (isset($_GET['error'])) {
    if ($_GET['error'] == "search_failed") {
        $error = "Search Failed";
    }
}
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

    <title>Dashboard Admin: <?php echo $username ?> </title>
    <style>
        .search-container {
            margin: auto 4rem 2rem 0;
        }

        .search-container h2 {
            margin: 10px 5px 20px 0;
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
            padding: 8px;
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

        .b-button {
            margin-top: 10px;
            padding: 8px;
            color: white;
            background: purple;
            border: 2px solid wheat;
            border-radius: 7px;
        }

        .stock-update-wrapper {
            margin-bottom: 10px;
            display: inline-flex;
            align-items: center;
        }

        /* Label styling */
        .stock-label {
            font-size: 16px;
            color: var(--text-dark);
        }

        /* Number input styling */
        #stock-input {
            height: 35px;
            width: 60px;
            border: 1px solid var(--main-color);
            border-radius: 4px;
            text-align: center;
            outline: none;
            transition: border-color 0.3s ease;
        }

        #stock-input:focus {
            border-color: var(--light-purple);
        }

        /* Update button styling */
        .stock-update-button {
            background-color: #4b49AC;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        /* Hover effect for the button */
        .stock-update-button:hover {
            background-color: var(--light-purple);
        }

        /* Press (active) effect for the button */
        .stock-update-button:active {
            transform: scale(0.98);
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
            <a href="#" class="nav-link">Admin Dashboard : Search Books</a>
            <div class="nav-link-2">
                <a href="admin_dashboard.php" class="profile">
                    <img src="img/people.png">
                </a>
            </div>
        </nav>
        <!-- NAVBAR -->

        <div id="main-content">
            <h2>
                <?php
                if ($msg_from_edit) {
                    echo "<div class='error'> $msg_from_edit </div>";
                }
                if ($error) {
                    echo "<div> class='error'> $error </div>";
                }
                ?>
            </h2>
            <div class="search-container">
                <h2>Search Books</h2>

                <!-- Search Form -->
                <form action="admin_searchbooks.php" method="GET" class="form-group">
                    <label for="search">Search by Title or Author:</label>
                    <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search_query); ?>"
                        required>
                    <input type="submit" value="Search">
                </form>

                <?php
                if (!empty($search_results)): ?>
                    <h3>Search Results:</h3>
                    <div class="grid-container">
                        <?php foreach ($search_results as $row): ?>
                            <div class="grid-item">
                                <img src="./bookspic/<?php echo htmlspecialchars($row['book_img']); ?>"
                                    alt="<?php echo htmlspecialchars($row['title']); ?>">
                                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                                <p>by <?php echo htmlspecialchars($row['author']); ?></p>
                                <p class="price">Rs.<?php echo htmlspecialchars($row['price']); ?></p>

                                <form action="admin_searchbooks.php" method="post" class="stock-update-wrapper">
                                    <input type="hidden" name="book_id" value="<?php echo $row['id']; ?>">
                                    <label for="stock-input-<?php echo $row['id']; ?>" class="stock-label">Stock:</label>
                                    <input type="number" id="stock-input" name="stock-input"
                                        value="<?php echo htmlspecialchars($row['stock']); ?>" min="0">
                                    <input type="submit" class="stock-update-button" value="Update" name="book_stock_update">
                                </form>

                                <div>
                                    <p>
                                        <a class="b-button"
                                            href="admin_book_profile.php?book_id=<?php echo $row['id']; ?>">View</a>
                                        <a class="b-button"
                                            href="admin_editbooks.php?book_title=<?php echo urlencode($row['title']); ?>">Edit</a>
                                    </p>

                                    <form method="POST" action="admin_delbook.php" name="delbook">
                                        <input type="hidden" name="book_title"
                                            value="<?php echo htmlspecialchars($row['title']); ?>">
                                        <input type="hidden" name="del_from_search" value="1">
                                        <button class="b-button" type="submit" name="delete">Delete</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php elseif (!empty($search_query)): ?>
                    <p>No results found for "<?php echo htmlspecialchars($search_query); ?>".</p>
                <?php endif; ?>
            </div>
        </div>



    </section>





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