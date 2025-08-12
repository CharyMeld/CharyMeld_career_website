<?php
// Start session
session_start();

// Include database connection
require_once __DIR__ . '/../../config/database.php';

// Ensure the upload directory exists
$uploadDir = __DIR__ . '/../../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$successMessage = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    $imagePath = null;
    $thumbnailPath = null;

    // Handle blog image upload
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . '_img_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = 'uploads/' . $imageName;
        } else {
            $errorMessage = "Failed to upload blog image.";
        }
    }

    // Handle thumbnail upload
    if (!empty($_FILES['thumbnail']['name'])) {
        $thumbName = time() . '_thumb_' . basename($_FILES['thumbnail']['name']);
        $thumbTargetFile = $uploadDir . $thumbName;

        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbTargetFile)) {
            $thumbnailPath = 'uploads/' . $thumbName;
        } else {
            $errorMessage = "Failed to upload thumbnail.";
        }
    }

    // Insert data into database
    if (!$errorMessage) {
        $sql = "INSERT INTO blog (title, content, image, thumbnail, created_at) 
                VALUES (:title, :content, :image, :thumbnail, NOW())";

        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':image' => $imagePath,
            ':thumbnail' => $thumbnailPath
        ]);

        if ($success) {
            $successMessage = "Blog added successfully!";
            header("refresh:2; url=blog_management.php"); // Redirect after 2 seconds
        } else {
            $errorMessage = "Failed to add blog.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h2 class="mb-4 text-center">Add New Blog</h2>
            
            <?php if ($successMessage): ?>
                <div class="alert alert-success"> <?= $successMessage ?> </div>
            <?php endif; ?>
            
            <?php if ($errorMessage): ?>
                <div class="alert alert-danger"> <?= $errorMessage ?> </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" class="form-control" rows="5" required></textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Upload Blog Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Thumbnail</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Add Blog</button>
            </form>
        </div>
    </div>
</body>
</html>
