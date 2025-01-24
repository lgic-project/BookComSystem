<?php
// Database Configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'bookcomsystem');

// Attempt to connect to MySQL database
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check connection and handle errors
if ($mysqli->connect_errno) {
    // Log the error to a file for debugging (optional)
    error_log("Database connection failed: " . $mysqli->connect_error);
    
    // Display a user-friendly message
    die("Database connection failed. Please try again later.");
}

// Optional: Set character set to UTF-8
if (!$mysqli->set_charset("utf8mb4")) {
    error_log("Error loading character set utf8mb4: " . $mysqli->error);
    die("Error configuring the database connection.");
}
?>
