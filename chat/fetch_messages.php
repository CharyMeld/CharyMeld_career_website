<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Correctly include the database connection file
require_once "../config/database.php"; // This defines $pdo

try {
    // Prepare and execute the SQL query
    $stmt = $pdo->prepare("SELECT * FROM chat_messages ORDER BY id DESC LIMIT 50");
    $stmt->execute();

    // Fetch messages as associative arrays
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return messages as JSON
    echo json_encode($messages);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database query failed: ' . $e->getMessage()]);
}
exit();
