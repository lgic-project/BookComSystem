<?php
// Start the session to track user information (like cart contents)
session_start();

// Example: Check if there are items in the cart
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>
    <link rel="stylesheet" href="assets/css/styles.css">

</head>
<body>
<?php include('includes/header.php'); ?>

    
    <!-- Main Content -->
    <div class="main-content">
        <h1>Welcome to E-Pasal</h1>
        <p>Explore our collection of books.</p>

        <!-- Example of displaying books dynamically -->
        <div class="book-list">
            <?php
            // Example: Fetch books from the database (this is just a mockup)
            $books = [
                ['title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'price' => '$10'],
                ['title' => '1984', 'author' => 'George Orwell', 'price' => '$12'],
                ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'price' => '$14']
            ];

            foreach ($books as $book) {
                echo "<div class='book-item'>
                        <h2>{$book['title']}</h2>
                        <p>by {$book['author']}</p>
                        <p>Price: {$book['price']}</p>
                        <button>Add to Cart</button>
                      </div>";
            }
            ?>
        </div>
    </div>

    <!-- Footer Section -->
    <?php include('includes/footer.php'); ?>
</body>
</html>
