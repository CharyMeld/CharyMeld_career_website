<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image']) && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    $file = $_FILES['profile_image'];

    // Validate file type and size (max 2MB)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes) || $file['size'] > 2 * 1024 * 1024) {
        $_SESSION['error'] = "Invalid file type or file too large (max 2MB).";
        header("Location: /myphpproject/index.php?page=userdashboard");
        exit();
    }

    // Generate a unique file name
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = 'profile_' . $userId . '_' . time() . '.' . $extension;

    // Correct the upload directory path (relative to project root)
    $uploadDir = realpath(__DIR__ . '/../../') . '/uploads/profile_images/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadPath = $uploadDir . $newFileName;

    // Move file to upload directory
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        // Update database
        $stmt = $pdo->prepare("UPDATE users SET profile_image = :profile_image WHERE id = :id");
        $stmt->execute(['profile_image' => $newFileName, 'id' => $userId]);

        // Update session variable
        $_SESSION['profile_image'] = $newFileName;
        $_SESSION['success'] = "Profile image updated successfully.";
    } else {
        $_SESSION['error'] = "Error uploading image. Please try again.";
    }

    header("Location: /myphpproject/index.php?page=userdashboard");
    exit();
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: /myphpproject/index.php?page=userdashboard");
    exit();
}
