<?php

header('Content-Type: application/json');

require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

if (!isset($_POST['post_id']) || !is_numeric($_POST['post_id'])) {
    echo json_encode(["success" => false, "message" => "Invalid post ID."]);
    exit;
}

$postId = intval($_POST['post_id']);
$ipAddress = $_SERVER['REMOTE_ADDR']; // ✅ Get user's IP

try {
    // ✅ Check if user already liked
    $stmt = $pdo->prepare("SELECT id FROM likes WHERE blog_id = ? AND ip_address = ?");
    $stmt->execute([$postId, $ipAddress]);

    if ($stmt->rowCount() == 0) {
        // ✅ Insert new like
        $stmt = $pdo->prepare("INSERT INTO likes (blog_id, ip_address) VALUES (?, ?)");
        $stmt->execute([$postId, $ipAddress]);
    }

    // ✅ Get updated like count
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE blog_id = ?");
    $stmt->execute([$postId]);
    $likeCount = $stmt->fetchColumn();

    echo json_encode(["success" => true, "new_likes" => $likeCount]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
}
?>
