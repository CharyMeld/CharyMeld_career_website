<?php
header("Content-Type: application/json");
require_once "../../config/database.php"; // Ensure correct path

$blogId = isset($_GET['blog_id']) ? intval($_GET['blog_id']) : 0;
if ($blogId == 0) {
    echo json_encode(["status" => "error", "message" => "Invalid Blog ID"]);
    exit;
}

try {
    // ✅ Use `$pdo` instead of `$conn`
    $sql = "SELECT username, comment, created_at FROM comments WHERE blog_id = :blog_id ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':blog_id', $blogId, PDO::PARAM_INT);
    $stmt->execute();

    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["status" => "success", "comments" => $comments]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
