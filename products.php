<?php
// Include database connection
include 'connection/config.php'; // Update this path as needed

// Fetch books from the database
$sql = "SELECT * FROM books";
$result = $mysqli->query($sql);

if (!$result) {
    die("Error fetching books: " . $mysqli->error);
}
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #6200ea;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            max-width: 80%;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .buttons button {
            background: #6200ea;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 20px;
            cursor: pointer;
            margin: 5px;
        }

        .buttons button:hover {
            background: #3700b3;
        }

        #popup-message {
            display: none;
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #6200ea;
            color: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }
    </style>
</head>
<body>
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
    <div id="popup-message"><p>Added to cart</p></div>

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
</body>
</html>
