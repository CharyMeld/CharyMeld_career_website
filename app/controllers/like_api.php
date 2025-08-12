<?php
header("Content-Type: application/json");
require_once "../../config/database.php"; // Ensure correct database connection

if (!isset($_POST['blog_id'])) {
    echo json_encode(["status" => "error", "message" => "Invalid Blog ID"]);
    exit;
}

$blogId = intval($_POST['blog_id']);

// Check if the blog post exists
$stmt = $pdo->prepare("SELECT likes FROM blog WHERE id = ?");
$stmt->execute([$blogId]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    echo json_encode(["status" => "error", "message" => "Blog not found"]);
    exit;
}

// Update the like count
$newLikeCount = $blog['likes'] + 1;
$updateStmt = $pdo->prepare("UPDATE blog SET likes = ? WHERE id = ?");
$updateSuccess = $updateStmt->execute([$newLikeCount, $blogId]);

if ($updateSuccess) {
    echo json_encode(["status" => "success", "likes" => $newLikeCount]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update likes"]);
}
?>
