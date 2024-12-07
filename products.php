<?php
// Include database connection
include 'connection/config.php'; // Update this path as needed

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
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        h1 {
            text-align: center;
            font-size: 2.5rem;
            margin-top: 20px;
            color: #6200ea;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 10px;
        }

        /* Product Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        /* Product Card */
        .product-card {
            background: linear-gradient(145deg, #ffffff, #f0f0f0);
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            max-width: 80%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .product-card:hover img {
            transform: scale(1.1);
        }

        .product-card h3 {
            font-size: 1.4rem;
            margin: 10px 0;
            color: #333;
        }

        .product-card p {
            margin: 5px 0;
            color: #555;
            font-size: 0.9rem;
        }

        /* Buttons */
        .buttons {
            margin-top: 15px;
        }

        .product-card button {
            background: #6200ea;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.3s ease;
            margin: 5px;
        }

        .product-card button:hover {
            background: #3700b3;
            transform: scale(1.05);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-card {
            animation: fadeIn 0.6s ease;
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
                        <form action="add_to_cart.php" method="POST" style="display: inline;">
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                            <button type="submit">Add to Cart</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
