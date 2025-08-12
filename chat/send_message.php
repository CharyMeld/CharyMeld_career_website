<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Include database connection
require_once "../config/database.php"; // ensures $pdo is available

// Check if data was sent
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = isset($_POST['user']) ? trim($_POST['user']) : 'Guest';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if ($message !== '') {
        try {
            $stmt = $pdo->prepare("INSERT INTO chat_messages (user, message) VALUES (:user, :message)");
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':message', $message);
            $stmt->execute();

            echo json_encode(['status' => 'success', 'message' => 'Message sent']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database insert failed: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Message cannot be empty.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}


$attachmentPath = null;
if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === 0) {
    $uploadDir = "../uploads/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $filename = time() . "_" . basename($_FILES["attachment"]["name"]);
    $targetFile = $uploadDir . $filename;

    if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFile)) {
        $attachmentPath = "uploads/" . $filename;
    }
}

// Get user avatar (assumed you have a users table with avatar column)
$avatar = 'default.png';  // Use default if not set
$stmt = $pdo->prepare("SELECT avatar FROM users WHERE username = ?");
$stmt->execute([$user]);
$userData = $stmt->fetch();
if ($userData) {
    $avatar = $userData['avatar'];
}

// Insert message
$stmt = $pdo->prepare("INSERT INTO chat_messages (user, message, attachment, avatar, timestamp) VALUES (?, ?, ?, ?, NOW())");
$stmt->execute([$user, $message, $attachmentPath, $avatar]);

exit();
