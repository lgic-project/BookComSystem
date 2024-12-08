<?php

include('./connection/config.php');

if (isset($_GET['bookedit'])) {
    if ($_GET['bookedit'] === 'success') {
        echo "<h5>Book edit success <h5>";
    }
}

$search_results = [];
$search_query = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    $search_query = $_GET['search'];

    // Search the database for books matching the title or author
    $sql = "SELECT * FROM books WHERE title LIKE ? OR author LIKE ?";
    $stmt = $mysqli->prepare($sql);
    $search_term = "%" . $search_query . "%"; // For partial matching
    $stmt->bind_param('ss', $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the results into an array
    while ($row = $result->fetch_assoc()) {
        $search_results[] = $row;
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

    <title>Dashboard Admin: <?php echo $username ?> </title>
    <style>
        
        .search-container h2{
            margin: 10px 5px 20px 5px;
            text-align: center;
            font-size: 30px;
            color: purple;
        }

        .search-container .form-group{
            display: flex;
            justify-content: center;
            gap: 10px;
            font-size: larger;
        }

        

        .search-container .form-group input[type='submit']{
            padding: 3px;
        }

        .search-container h3{
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
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">Bookly</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="#">
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
                    <span class="text">Statistics</span>
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
                <a href="admin_dashboard.php" class="profile">
                    <img src="img/people.png">
                </a>
            </div>
        </nav>
        <!-- NAVBAR -->
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
                    <?php
                    foreach ($search_results as $row) {
                        echo '<div class="grid-item">';
                        echo '<img src="./bookspic/' . $row['book_img'] . '" alt="' . htmlspecialchars($row['title']) . '">';
                        echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                        echo '<p>by ' . htmlspecialchars($row['author']) . '</p>';
                        echo '<p class="price">$' . htmlspecialchars($row['price']) . '</p>';
                        echo "<p><a  class='edit-button' href='admin_editbooks.php?book_title=" . $row['title'] . "' >Edit</a></p>";
                        echo '</div>';
                    }
                    ?>
                </div>
            <?php elseif (!empty($search_query)): ?>
                <p>No results found for "<?php echo htmlspecialchars($search_query); ?>".</p>
            <?php endif; ?>

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