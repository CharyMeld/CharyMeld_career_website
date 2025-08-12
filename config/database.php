<?php
try {
    $host = "localhost"; // Database host (usually "localhost" on Hostinger)
    $dbname = "admindashboard"; // Database name (based on what you mentioned)
    $username = "root"; // Database username
    $password = "CharyMeld"; // Replace with the actual password for your MySQL user

    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exception
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage()); // Debugging output if connection fails
}
?>
