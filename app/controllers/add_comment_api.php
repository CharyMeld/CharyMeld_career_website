<?php
header("Content-Type: application/json");
require_once "../../config/database.php"; // Ensure correct path

$blogId = isset($_POST['blog_id']) ? intval($_POST['blog_id']) : 0;
$username = isset($_POST['username']) ? trim($_POST['username']) : "";
$comment = isset($_POST['comment']) ? trim($_POST['comment']) : "";

if (empty($blogId) || empty($username) || empty($comment)) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit;
}

try {
    // ✅ Use `$pdo` instead of `$conn`
    $sql = "INSERT INTO comments (blog_id, username, comment, created_at) VALUES (:blog_id, :username, :comment, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':blog_id', $blogId, PDO::PARAM_INT);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Comment added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add comment"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
