<?php
$query = $_GET['query'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="main-content">
        <h1>Search Results for "<?php echo htmlspecialchars($query); ?>"</h1>
        <!-- Search result items go here -->
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>
