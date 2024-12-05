<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Commercial Site</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body class="light-mode">
    <div class="theme-toggle" onclick="toggleTheme()">Switch Theme</div>

    <section class="banner">
        <h1>Welcome to E Book Pasal</h1>
        <p>Your journey to knowledge begins here.</p>
    </section>

    <section class="scroll-container">
        <div class="card">
            <img src="developerpic/bishal.jpg" alt="Book Cover">
            <h3>Book Title 1</h3>
            <p>Author: John Doe</p>
            <p>Price: $19.99</p>
            <button class="btn">Buy Now</button>
        </div>

        <div class="card">
            <img src="developerpic/bishal.jpg" alt="Book Cover">
            <h3>Book Title 2</h3>
            <p>Author: Jane Smith</p>
            <p>Price: $15.49</p>
            <button class="btn">Buy Now</button>
        </div>

        <div class="card">
            <img src="developerpic/bishal.jpg" alt="Book Cover">
            <h3>Book Title 3</h3>
            <p>Author: Alice Johnson</p>
            <p>Price: $22.99</p>
            <button class="btn">Buy Now</button>
        </div>

        <!-- Add more cards as needed -->
    </section>

<script>
function scrollLeft() {
    const container = document.querySelector('.scrollable');
    if (container) {
        container.scrollBy({ left: -200, behavior: 'smooth' });
    }
}

function scrollRight() {
    const container = document.querySelector('.scrollable');
    if (container) {
        container.scrollBy({ left: 200, behavior: 'smooth' });
    }
}
function toggleTheme() {
            document.body.classList.toggle('light-mode');
            document.body.classList.toggle('dark-mode');
        }
</script>
</body>
</html>
