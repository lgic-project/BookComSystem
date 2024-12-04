<?php
    // Start the session
    session_start();

    // Load components dynamically
    function loadComponent($component) {
        include_once __DIR__ . "/components/$component.php";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sasto E-Pasal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>