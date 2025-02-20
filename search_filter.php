<?php
require_once "./connection/config.php";
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'light-mode';
}


//for search handling 
if (isset($_POST['search_query_btn'])) {

    $search_query = $_POST['search_query'];
    $search_term = $_POST['search_query'];
    $search_sql = "SELECT title,author, price, book_img FROM books WHERE title LIKE ? OR author LIKE ?";
    $stmt = $mysqli->prepare($search_sql);

    $search_term = "%" . $search_term . "%"; // Adding wildcard for LIKE
    $stmt->bind_param("ss", $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
}


//sorting code 

function byPriceAsc($query, $mysqli)
{
    $search_sql = "SELECT title, author, price, book_img FROM books WHERE title LIKE ? OR author LIKE ? ORDER BY price ASC";
    $stmt = $mysqli->prepare($search_sql);

    $query = "%" . $query . "%"; // Adding wildcard for LIKE
    $stmt->bind_param("ss", $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
function byPriceDesc($query, $mysqli)
{
    $search_sql = "SELECT title, author, price, book_img FROM books WHERE title LIKE ? OR author LIKE ? ORDER BY price Desc";
    $stmt = $mysqli->prepare($search_sql);

    $query = "%" . $query . "%"; // Adding wildcard for LIKE
    $stmt->bind_param("ss", $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
function byTitleAsc($query, $mysqli)
{
    $search_sql = "SELECT title, author, price, book_img FROM books WHERE title LIKE ? OR author LIKE ? ORDER BY title ASC";
    $stmt = $mysqli->prepare($search_sql);

    $query = "%" . $query . "%"; // Adding wildcard for LIKE
    $stmt->bind_param("ss", $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
function byTitledesc($query, $mysqli)
{
    $search_sql = "SELECT title, author, price, book_img FROM books WHERE title LIKE ? OR author LIKE ? ORDER BY title Desc";
    $stmt = $mysqli->prepare($search_sql);

    $query = "%" . $query . "%"; // Adding wildcard for LIKE
    $stmt->bind_param("ss", $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function category($query, $category, $mysqli)
{
    $search_sql = "SELECT title, author, price, book_img FROM books WHERE title LIKE ? OR author LIKE ? AND genre = ?";
    $stmt = $mysqli->prepare($search_sql);

    $query = "%" . $query . "%"; // Adding wildcard for LIKE
    $stmt->bind_param("sss", $query, $query, $category);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
function catetitleasc($query, $category, $mysqli)
{
    $search_sql = "SELECT title, author, price, book_img FROM books WHERE title LIKE ? OR author LIKE ? AND genre = ? ORDER BY title ASC";
    $stmt = $mysqli->prepare($search_sql);

    $query = "%" . $query . "%"; // Adding wildcard for LIKE
    $stmt->bind_param("sss", $query, $query, $category);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function catetitledesc($query, $category, $mysqli)
{
    $search_sql = "SELECT title, author, price, book_img FROM books WHERE title LIKE ? OR author LIKE ? AND genre = ? ORDER BY title Desc";
    $stmt = $mysqli->prepare($search_sql);

    $query = "%" . $query . "%"; // Adding wildcard for LIKE
    $stmt->bind_param("sss", $query, $query, $category);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function catetitlepriceasc($query, $category, $mysqli)
{
    $search_sql = "SELECT title, author, price, book_img FROM books WHERE title LIKE ? OR author LIKE ? AND genre = ? ORDER BY price ASC";
    $stmt = $mysqli->prepare($search_sql);

    $query = "%" . $query . "%"; // Adding wildcard for LIKE
    $stmt->bind_param("sss", $query, $query, $category);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function catetitlepricedesc($query, $category, $mysqli)
{
    $search_sql = "SELECT title, author, price, book_img FROM books WHERE title LIKE ? OR author LIKE ? AND genre = ? ORDER BY price Desc";
    $stmt = $mysqli->prepare($search_sql);

    $query = "%" . $query . "%"; // Adding wildcard for LIKE
    $stmt->bind_param("sss", $query, $query, $category);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}


if (isset($_POST['sort'])) {

    $category = $_POST['category'];
    $sort_by = $_POST['sort_by'];
    $search_query = $_POST['search_query'];
    $search_term = $_POST['search_query'];
    if (!$category) {
        switch ($sort_by) {
            case 'Price: Low to High':
                $result = byPriceAsc($search_query, $mysqli);
                break;
            case 'Price: High to Low':
                $result = byPriceDesc($search_query, $mysqli);
                break;
            case 'Title: A to Z':
                $result = byTitleAsc($search_query, $mysqli);
                break;
            case 'Title: Z to A':
                $result = byTitledesc($search_query, $mysqli);
                break;
            default:
                $result = $mysqli->query("SELECT title, author, price, book_img FROM books WHERE title LIKE '%$search_query%' OR author LIKE '%$search_query%'");
                break;
        }
    } else {
        switch ($sort_by) {
            case 'Price: Low to High':
                $result = catetitlepriceasc($search_query, $category, $mysqli);
                break;
            case 'Price: High to Low':
                $result = catetitlepricedesc($search_query, $category, $mysqli);
                break;
            case 'Title: A to Z':
                $result = catetitleasc($search_query, $category, $mysqli);
                break;
            case 'Title: Z to A':
                $result = catetitledesc($search_query, $category, $mysqli);
                break;
            default:
                $result = category($search_query, $category, $mysqli);
                break;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website</title>

    <!-- Linking external CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .container {
            display: flex;
            flex-direction: row;
            gap: 40px;
            margin: 60px 0px 60px 60px;
        }

        .container .sidebar {
            width: 180px;
            height: 100%;
            background-color: #f4f4f4;
            color: white;
            border-radius: 10px;
            padding: 20px;
        }

        .container .search-results {
            margin: auto 0px;
            width: calc(100% - 180px);
        }

        .search-content .section-1 {
            display: flex;
            flex-direction: row;
            margin-left: 120px;
            margin-bottom: 10px;
        }

        .section-1 #search_query {
            border-radius: 20px;
        }

        .section-1 button {
            border-radius: 20px;
            background-color: #4b49ac;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        .section-1 button:hover {
            background-color: #6c63ff;
            transition: 0.5s;
        }


        .search-content .section-1 #search_query {
            width: 700px;
            padding: 10px;
            margin: auto 10px;

        }

        .grid {
            margin-left: 70px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
            width: 230px;
            gap: 20px;
            text-align: center;
            background: white;
            padding: 15px;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .card-content {
            padding: 10px;
        }

        .card-content h3 {
            margin: 10px 0;
            font-size: 18px;
            color: #333;
        }

        .card-content p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .price {
            font-size: 16px;
            font-weight: bold;
            color: #e44d26;
        }

        a {
            text-decoration: none;
            color: inherit;
        }



        .sidebar {
            color: #6a0dad;
            width: auto;
            padding: 20px;
            border-radius: 10px;
            color: white;
        }
        h2 {
            color: #6a0dad;
            text-align: center;
            margin-bottom: 15px;
        }
        p {
            font-weight: bold;
        }
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: none;
        }
        .content-sidebar {
            width: 250px;
            padding: 10px;
            border-radius: 10px;
        }
        select {
            background: #fff;
            color: #333;
        }
        .filter-form  button {
            width: 100px;
            height: 50px;
            margin: 10px;
            padding: 10px;
            border-radius: 8px;
            font-size: larger;
            background: #4b0082;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }
        .filter-form button:hover {
            background: #5e2a9e;
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <main class="container">

        <div class="sidebar">
            <h2>Filter</h2>

            <div class="content-sidebar">
                <p>Sort By:</p>
                <form action="search_filter.php" class="filter-form" method="post">
                    <input type="hidden" name="search_query"  value="<?php echo $search_query ?>">
                    <select name="sort_by" id="sort_by">
                        <?php if ($sort_by) {
                            echo "<option value='$sort_by'>$sort_by</option>";
                        }
                        ?>
                        <option value="Price: Low to High">Price: Low to High</option>
                        <option value="Price: High to Low">Price: High to Low</option>
                        <option value="Title: A to Z">Title: A to Z</option>
                        <option value="Title: Z to A">Title: Z to A</option>
                    </select>
                    <select name="category" id="category">
                        <?php if ($category) {
                            echo "<option value='$category'>$category</option>";
                        }
                        ?>
                        <option value="">Default</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Sci-Fi">Sci-Fi</option>
                        <option value="Biography">Biography</option>
                        <option value="History">History</option>
                        <option value="Mystery/Thriller">Mystery/Thriller</option>
                        <option value="Romance">Romance</option>
                        <option value="Horror">Horror</option>
                        <option value="Self-Help">Self-Help</option>
                        <option value="Other">Other</option>
                    </select>
                    <button type="submit" name="sort">Sort</button>
                </form>
            </div>
        </div>
        <div class="search-content">
            <form action="search_filter.php" class="section-1" method="post">
                <input type="text" name="search_query" id="search_query" value="<?php echo $search_query ?>"
                    placeholder="Search for books...">
                <button type="submit" name="search_query_btn">Search</button>
            </form>
            <div class="section-2">
                <h2>Search Results</h2>
                <div class="search-results">
                    <?php if ($result->num_rows > 0) { ?>
                        <div class="grid">
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <!-- <a href="book.php?id=<?php echo $row['id']; ?>"> -->
                                <div class="card">
                                    <img src="./bookspic/<?php echo $row['book_img']; ?>" alt="<?php echo $row['title']; ?>">
                                    <div class="card-content">
                                        <h3><?php echo $row['title']; ?></h3>
                                        <p> By <?php echo $row['author']; ?></p>
                                        <p class="price">Rs.<?php echo $row['price']; ?></p>
                                    </div>
                                </div>
                                </a>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <p>No books found.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>

</body>

</html>