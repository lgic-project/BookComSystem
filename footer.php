<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>
<style>
    /* General reset for footer */
footer {
    background-color: #6a0dad; /* Deep purple background */
    color: #fff;
    width: 100%;
    padding: 20px 0;
    font-family: 'Arial', sans-serif;
    position: relative;
    height: auto; /* Fixed height for half height effect */
}

/* Footer Container */
.footer .box-container {
    display: flex;
    justify-content: space-around;
    padding: auto 20px;
    margin: auto 120px;
}



/* Each Box */
.footer .box-container .box {
    flex: 1;
    padding: 10px;
    margin: 0 10px;
    display: flex;
    flex-direction: column;
    justify-content:left;
    align-items: center;
}

/* Logo styling (if you add an image) */
.footer .box-container .box img {
    width: 200px; /* Adjusted logo size */
    margin-bottom: 15px;
    align-self: center;
}

/* Header in each box */
.footer .box-container .box h3 {
    font-size: 18px;
    margin-bottom: 15px;
    text-transform: uppercase;
    font-weight: bold;
    letter-spacing: 1px;
    animation: fadeIn 1s ease-out;
    text-align: center;
    color: #f1f1f1; /* Lighter text for headers */
}

/* Styling links */
.footer .box-container .box a {
    color: #f1f1f1; /* Light color for links */
    display: block;
    margin: 5px 0;
    font-size: 14px;
    text-decoration: none;
    transition: color 0.3s ease-in-out;
    text-align: center;
}

.footer .box-container .box p{
    color: #f1f1f1; /* Light color for links */
    display: block;
    margin: 5px 0;
    font-size: 14px;
    text-decoration: none;
    transition: color 0.3s ease-in-out;
}



.footer .box-container .box a:hover {
    color: #ffb3e6; /* Light pink hover effect */
}

/* Contact info icons */
.footer .box p i {
    margin-right: 10px;
}

/* Social media icons */
.footer .box a i {
    font-size: 20px;
    margin-right: 15px;
    transition: transform 0.3s ease-in-out;
}

.footer .box a:hover i {
    transform: scale(1.2); /* Icon zoom effect */
}

/* Animation for the footer's content */
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

.footer .credit {
    text-align: center;
    font-size: 14px;
    margin-top: 20px;
    color: white; /* Lighter color for copyright text */
    animation: fadeIn 2s ease-out;
}

/* Small screen adjustments */
@media (max-width: 768px) {
    .footer .box-container {
        flex-direction: column;
        align-items: center;
    }
    .footer .box {
        margin-bottom: 15px;
    }
    .footer .box img {
        width: 60px; /* Adjust logo size for smaller screens */
    }
    .footer .box h3 {
        font-size: 16px; /* Reduce header font size */
    }
    .footer .box a {
        font-size: 14px; /* Adjust link font size for small screens */
    }
}

    </style>

<footer class="footer">

    <div class="box-container">
        <div class="box">
            <img src="logo/logo-removebg-preview.png" alt="logo">
        </div>
        <div class="box">
            <h3>Quick links</h3>
            <a href="index.php">Home</a>
            <a href="index.php?page=about">About Us</a>
            <a href="shop.php">Shop</a>
            <a href="contact.php">Contact</a>
        </div>

        <div class="box">
            <h3>Contact info</h3>
            <p><i class="fas fa-phone"></i> +977-9746311761</p>
            <p><i class="fas fa-phone"></i> +977-9746311761</p>
            <p><i class="fas fa-envelope"></i> epasal4156@gmail.com</p>
            <p><i class="fas fa-map-marker-alt"></i> Pokhara, Nepal - 33700</p>
        </div>

        <div class="box">
            <h3>Follow Us</h3>
            <a href="#"> <i class="fab fa-facebook-f"></i> Facebook </a>
            <a href="#"> <i class="fab fa-twitter"></i> Twitter </a>
            <a href="#"> <i class="fab fa-instagram"></i> Instagram </a>
            <a href="#"> <i class="fab fa-linkedin"></i> LinkedIn </a>
        </div>

    </div>

    <p class="credit"> &copy; copyright @ <?php echo date('Y'); ?> by <span>Bookly</span> </p>

</footer>
