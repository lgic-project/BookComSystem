<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Commercial Site</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
<section class="banner">
    <h1>Welcome to E Book Pasal</h1>
    <p>Discover your next great read!</p>
</section>

<section class="top-books">
    <h2>Top Bought Books</h2>
    <div class="scroll-container">
        <button class="scroll-btn left-btn" onclick="scrollLeft()">&#8249;</button>
        <div class="scrollable">
            <div class="book">
                <img src="top1.jpg" alt="Top Book 1">
                <h3>Top Book 1</h3>
            </div>
            <div class="book">
                <img src="top2.jpg" alt="Top Book 2">
                <h3>Top Book 2</h3>
            </div>
            <div class="book">
                <img src="top3.jpg" alt="Top Book 3">
                <h3>Top Book 3</h3>
            </div>
            <div class="book">
                <img src="top1.jpg" alt="Top Book 1">
                <h3>Top Book 1</h3>
            </div>
            <div class="book">
                <img src="top2.jpg" alt="Top Book 2">
                <h3>Top Book 2</h3>
            </div>
            <div class="book">
                <img src="top3.jpg" alt="Top Book 3">
                <h3>Top Book 3</h3>
            </div>
            <div class="book">
                <img src="top1.jpg" alt="Top Book 1">
                <h3>Top Book 1</h3>
            </div>
            <div class="book">
                <img src="top2.jpg" alt="Top Book 2">
                <h3>Top Book 2</h3>
            </div>
            <div class="book">
                <img src="top3.jpg" alt="Top Book 3">
                <h3>Top Book 3</h3>
            </div>
            <!-- Add more books as needed -->
        </div>
        <button class="scroll-btn right-btn" onclick="scrollRight()">&#8250;</button>
    </div>
</section>

<section class="book-grid">
    <h2>Featured Books</h2>
    <div class="books">
        <div class="book">
            <img src="book1.jpg" alt="Book 1">
            <h3>Book Title 1</h3>
            <p>$15.99</p>
        </div>
        <div class="book">
            <img src="book2.jpg" alt="Book 2">
            <h3>Book Title 2</h3>
            <p>$12.49</p>
        </div>
        <div class="book">
            <img src="book3.jpg" alt="Book 3">
            <h3>Book Title 3</h3>
            <p>$19.99</p>
        </div>
    </div>
</section>

<section class="about">
    <h2>About Us</h2>
    <p>E Book Pasal is your one-stop shop for amazing books. We provide a wide range of collections to satisfy every reader.</p>
</section>

<script>
    function scrollLeft() {
        const container = document.querySelector('.scrollable');
        container.scrollBy({ left: -200, behavior: 'smooth' });
    }

    function scrollRight() {
        const container = document.querySelector('.scrollable');
        container.scrollBy({ left: 200, behavior: 'smooth' });
    }
</script>
</body>
</html>
