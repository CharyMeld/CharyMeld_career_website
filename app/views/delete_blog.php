<?php
// Start session
session_start();

// Correct database path
require_once __DIR__ . '/../../config/database.php';

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request.");
}

$blogId = $_GET['id'];

// Fetch blog details to delete image & thumbnail
$stmt = $pdo->prepare("SELECT image, thumbnail FROM blog WHERE id = :id");
$stmt->execute([':id' => $blogId]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    die("Blog not found.");
}

// Delete images if they exist
if (!empty($blog['image']) && file_exists(__DIR__ . '/../../' . $blog['image'])) {
    unlink(__DIR__ . '/../../' . $blog['image']);
}
if (!empty($blog['thumbnail']) && file_exists(__DIR__ . '/../../' . $blog['thumbnail'])) {
    unlink(__DIR__ . '/../../' . $blog['thumbnail']);
}

// Delete blog from database
$stmt = $pdo->prepare("DELETE FROM blog WHERE id = :id");
$success = $stmt->execute([':id' => $blogId]);

if ($success) {
    echo "Blog deleted successfully!";
    header("Location: blog_management.php");
    exit;
} else {
    echo "Failed to delete blog.";
}
?>
