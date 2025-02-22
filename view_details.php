<?php
include_once 'connection/config.php';

// Start the session
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}

// Check if 'id' is provided via GET and is numeric
if (isset($_GET["id"])) {

    $book_id = intval(urldecode($_GET["id"])); // Convert to integer for security
    // Fetch book details
    $sql = "SELECT author, title, price , book_description, book_img  FROM books WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        die("<p>No book found with ID <strong>$book_id</strong>.</p>");
    }
    $stmt->close();
} else {
    die("<p>Invalid request.</p>");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['title']); ?></title>
    <link rel="stylesheet" href="./css/products.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>

<style>
    /* Add your existing styles for book details */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }

    .book-details {
        width: 50%;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .book-details img {
        width: 200px;
        height: auto;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .book-details h2 {
        font-size: 24px;
        color: #333;
    }

    .book-details p {
        font-size: 18px;
        color: #666;
    }

    .book-details strong {
        color: #000;
    }

    .add-to-cart-btn {
        background: #28a745;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 15px;
    }

    .add-to-cart-btn:hover {
        background: #218838;
    }

    /* Modal and Overlay styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .cart-modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 30%;
        background: white;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        z-index: 1000;
        text-align: center;
    }

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

<body>
    <?php include 'header.php'; ?>

    <div class="book-details">
        <img src="bookspic/<?php echo htmlspecialchars($book['book_img']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
        <h2><?php echo htmlspecialchars($book['title']); ?></h2>
        <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
        <p><strong>Price:</strong> Rs.<?php echo htmlspecialchars($book['price']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($book['book_description']); ?></p>

        <!-- Add to Cart Button -->
        <button class="add-to-cart-btn" data-id="<?php echo $book_id; ?>">Add to Cart</button>
    </div>

    <!-- Modal Overlay and Modal -->
    <div class="modal-overlay" id="modal-overlay"></div>
    <div class="cart-modal" id="cart-modal">
        <p>Item added to cart!</p>
        <button class="confirm-btn" id="confirm-btn">Confirm</button>
    </div>

    <script>
        // Add event listener to Add to Cart button
        document.querySelector('.add-to-cart-btn').addEventListener('click', function () {
            const productId = this.dataset.id;

            // Send the product ID to add_to_cart.php using AJAX
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
                        // Show success modal
                        document.getElementById('cart-modal').style.display = 'block';
                        document.getElementById('modal-overlay').style.display = 'block';
                    }
                })
                .catch(err => console.error('Error:', err));
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
