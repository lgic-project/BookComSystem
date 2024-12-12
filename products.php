<?php
// Include database connection
include_once 'connection/config.php'; // Update this path as needed

// Fetch books from the database
$sql = "SELECT * FROM books";
$result = $mysqli->query($sql);

if (!$result) {
    die("Error fetching books: " . $mysqli->error);
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="./css/products.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <!-- Main Content -->
    <div class="container">
        <h1>Our Books</h1>
        <div class="products-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="bookspic/<?php echo htmlspecialchars($row['book_img']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p>Author: <?php echo htmlspecialchars($row['author']); ?></p>
                    <p>Price: $<?php echo htmlspecialchars($row['price']); ?></p>
                    <div class="buttons">
                        <form action="view_details.php" method="GET" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit">View Details</button>
                        </form>
                        <form class="add-to-cart-form" data-id="<?php echo $row['id']; ?>" style="display: inline;">
                            <button type="button">Add to Cart</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Popup for "Added to cart" -->
    <div id="popup-message"><p>Added to cart</p></div>

    <!-- JavaScript for Cart Functionality -->
    <script>
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('click', function () {
                const productId = this.dataset.id;

                fetch('add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `product_id=${productId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const popup = document.getElementById('popup-message');
                        popup.style.display = 'block';
                        setTimeout(() => { popup.style.display = 'none'; }, 2000);
                    } else {
                        alert(data.message || 'Failed to add to cart.');
                    }
                })
                .catch(err => console.error('Error:', err));
            });
        });
    </script>
    <?php include 'footer.php'?>
</body>
</html>
