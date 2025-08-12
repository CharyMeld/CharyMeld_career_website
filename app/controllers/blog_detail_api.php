<?php
header("Content-Type: application/json");

// Ensure the database connection is included
require_once __DIR__ . "/../../config/database.php";

// Debugging: Check if $pdo is set
if (!isset($pdo)) {
    echo json_encode(["status" => "error", "message" => "Database connection is missing."]);
    exit;
}

// Get blog ID
$blogId = $_GET['id'] ?? 0;
if (!$blogId) {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
    exit;
}

// Fetch blog details
try {
    $stmt = $pdo->prepare("SELECT id, title, image, content, likes FROM blog WHERE id = ?");
    $stmt->execute([$blogId]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($blog) {
        echo json_encode(["status" => "success", "blog" => $blog]);
    } else {
        echo json_encode(["status" => "error", "message" => "Blog not found."]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Query failed: " . $e->getMessage()]);
}
?>
