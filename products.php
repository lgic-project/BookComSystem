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
    <style>.cart-modal {
    display: none; /* Start hidden */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.8);
    width: 350px;
    background: #fff;
    padding: 30px;
    box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    z-index: 1000;
    text-align: center;
    opacity: 0;
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.cart-modal.show {
    display: block;
    opacity: 1;
    transform: translate(-50%, -50%) scale(1);
}

.modal-overlay {
    display: none; /* Start hidden */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 999;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal-overlay.show {
    display: block;
    opacity: 1;
}

/* Button styling */
.confirm-btn {
    margin-top: 20px;
    padding: 12px 20px;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s ease, transform 0.3s ease;
}

.confirm-btn:hover {
    background: #218838;
    transform: translateY(-2px);
}

.confirm-btn:active {
    transform: translateY(1px);
}

/* Subtle animation for the overlay */
.modal-overlay.show {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Responsive design for small screens */
@media (max-width: 480px) {
    .cart-modal {
        width: 80%;
        padding: 20px;
    }
    .confirm-btn {
        font-size: 14px;
        padding: 10px 15px;
    }
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
                            document.getElementById('cart-modal').classList.add('show');
                            document.getElementById('modal-overlay').classList.add('show');

                        }
                    })
                    .catch(err => console.error('Error:', err));
            });
        });

        // Close modal when clicking outside or on confirm button
        document.getElementById('modal-overlay').addEventListener('click', closeModal);
        document.getElementById('confirm-btn').addEventListener('click', closeModal);

        function closeModal() {
            document.getElementById('cart-modal').classList.remove('show');
document.getElementById('modal-overlay').classList.remove('show');

        }
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>
