<?php
// Start the session to manage theme preference across pages
session_start();

// Check if a theme toggle request is made
if (isset($_POST['theme'])) {
    // Set the theme in the session
    $_SESSION['theme'] = $_POST['theme'];
}

// Default theme (light) if no theme is set in the session
if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'light-mode';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sasto E-Pasal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <!-- for font and icons -->
    <link rel="stylesheet" href="./css/style.css"> <!-- Main stylesheet -->
    <link rel="stylesheet" href="./css/footer.css">
</head>

<body class="<?php echo $_SESSION['theme']; ?>"> <!-- Apply the theme class from session -->

    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <main>
        <?php
        // Check for the 'page' parameter in the URL to dynamically load content
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            switch ($page) {
                case 'about':
                    include 'about.php'; // Include about.php when the 'about' page is requested
                    break;
                // Add other cases for different pages as needed
                default:
                    include 'home.php'; // Default page if no page is specified
            }
        } else {
            include 'home.php'; // Default page if no page is specified
        }
        ?>
    </main>

    <?php include 'footer.php'; ?>

    <!-- Main JavaScript -->
    <script src="./js/script.js"></script>
</body>

</html>
