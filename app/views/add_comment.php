<?php
// add_comment.php

require_once __DIR__ . '/config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blog_id = $_POST['blog_id'] ?? null;
    $username = $_POST['username'] ?? '';
    $comment = $_POST['comment'] ?? '';

    if ($blog_id && $username && $comment) {
        $stmt = $pdo->prepare("INSERT INTO comments (blog_id, username, comment, created_at) VALUES (?, ?, ?, NOW())");
        $result = $stmt->execute([$blog_id, $username, $comment]);

        if ($result) {
            echo json_encode(['success' => true, 'username' => $username, 'comment' => $comment]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database insert failed.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
