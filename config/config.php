<?php
// Define the base URL for the project (change this to your actual Hostinger domain)
define('BASE_URL', '/myphpproject/'); // Replace with your actual domain

// Define the root path of the project only if not already defined
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__FILE__));
}

// Database connection (modify as needed)
try {
    // Update to match Hostinger's credentials
    $pdo = new PDO("mysql:host=localhost;dbname=admindashboard", "root", "CharyMeld"); // Update password
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

?>
