<?php
// Include database connection
include_once 'connection/config.php';

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <style>
        /* Centered Modal */
        .cart-modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 30%;
            background: white;
            padding: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            z-index: 1000;
            text-align: center;
        }

        /* Overlay Background */
        .modal-overlay {
            display: none;
            /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Button styling */
        .confirm-btn {
            margin-top: 10px;
            padding: 8px 15px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .confirm-btn:hover {
            background: #218838;
        }
    </style>
</head>

<body>
    <!-- Success Alert -->
    <div id="cartAlert"
        style="display: none; background: green; color: white; padding: 10px; position: fixed; top: 10px; right: 10px; border-radius: 5px;">
        Book added to cart successfully!
    </div>

    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Our Books</h1>
        <div class="products-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="bookspic/<?php echo htmlspecialchars($row['book_img']); ?>"
                        alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p>Author: <?php echo htmlspecialchars($row['author']); ?></p>
                    <p>Price: Rs.<?php echo htmlspecialchars($row['price']); ?></p>
                    <div class="buttons">
                        <form action="view_details.php" method="GET" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit">View Details</button>
                        </form>
                        <!-- Add to Cart Button -->
                        <button class="add-to-cart-btn" data-id="<?php echo $row['id']; ?>">Add to Cart</button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Overlay and Modal -->
    <div class="modal-overlay" id="modal-overlay"></div>
    <div class="cart-modal" id="cart-modal">
        <p>Item added to cart!</p>
        <button class="confirm-btn" id="confirm-btn">Confirm</button>
    </div>

    <script>
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function () {
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
                            // Show modal confirmation
                            document.getElementById('cart-modal').style.display = 'block';
                            document.getElementById('modal-overlay').style.display = 'block';
                        }
                    })
                    .catch(err => console.error('Error:', err));
            });
        });

        // Close modal when clicking outside or on confirm button
        document.getElementById('modal-overlay').addEventListener('click', closeModal);
        document.getElementById('confirm-btn').addEventListener('click', closeModal);

        function closeModal() {
            document.getElementById('cart-modal').style.display = 'none';
            document.getElementById('modal-overlay').style.display = 'none';
        }
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>
