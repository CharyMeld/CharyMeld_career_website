<?php
// Ensure ROOT_PATH is defined
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__, 2)); // adjust based on your folder structure
}

require_once ROOT_PATH . '/config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_comment') {
    $postId = intval($_POST['post_id']);
    $comment = trim($_POST['comment']);

    if (!empty($comment)) {
        $stmt = $pdo->prepare("INSERT INTO comments (blog_id, comment, created_at) VALUES (?, ?, NOW())");
        if ($stmt->execute([$postId, $comment])) {
            echo json_encode(['status' => 'success', 'message' => 'Comment added successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error occurred.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Comment cannot be empty.']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_comments') {
    $postId = intval($_GET['post_id']);
    $stmt = $pdo->prepare("SELECT * FROM comments WHERE blog_id = ? ORDER BY created_at DESC");
    $stmt->execute([$postId]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output = '';
    foreach ($comments as $comment) {
        $output .= "
        <div class='comment p-3 border rounded mb-2 bg-light shadow-sm'>
            <strong>Guest:</strong> " . htmlspecialchars($comment['comment']) . "
            <br><small class='text-muted'>" . date("F j, Y, g:i a", strtotime($comment['created_at'])) . "</small>
        </div>";
    }

    echo json_encode(['status' => 'success', 'html' => $output]);
    exit;
}
error_log("Invalid request received. Method: {$_SERVER['REQUEST_METHOD']}, Params: " . json_encode($_REQUEST));
// If request doesn't match:
echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
exit;
