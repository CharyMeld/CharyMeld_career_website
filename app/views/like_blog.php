<?php
// like_blog.php
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['blog_id'])) {
    $blog_id = (int) $_POST['blog_id'];

    $stmt = $pdo->prepare("UPDATE blog SET likes = likes + 1 WHERE id = ?");
    if ($stmt->execute([$blog_id])) {
        // Fetch new like count
        $countStmt = $pdo->prepare("SELECT likes FROM blog WHERE id = ?");
        $countStmt->execute([$blog_id]);
        $likes = $countStmt->fetch(PDO::FETCH_ASSOC)['likes'];

        echo json_encode(['status' => 'success', 'likes' => $likes]);
    } else {
        echo json_encode(['status' => 'error']);
    }
} else {
    echo json_encode(['status' => 'invalid_request']);
}
