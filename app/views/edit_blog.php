<?php
// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Correct database path
require_once __DIR__ . '/../../config/database.php';

// Check if blog ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request.");
}

$blogId = $_GET['id'];

// Fetch blog details
$stmt = $pdo->prepare("SELECT * FROM blog WHERE id = :id");
$stmt->execute([':id' => $blogId]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    die("Blog not found.");
}

// Update blog post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $updated_at = date("Y-m-d H:i:s");

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $imagePath = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../../' . $imagePath);
    } else {
        $imagePath = $blog['image']; // Keep old image if no new upload
    }

    // Handle thumbnail upload
    if (!empty($_FILES['thumbnail']['name'])) {
        $thumbnailPath = 'uploads/' . basename($_FILES['thumbnail']['name']);
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], __DIR__ . '/../../' . $thumbnailPath);
    } else {
        $thumbnailPath = $blog['thumbnail']; // Keep old thumbnail if no new upload
    }

    // Update database
    $stmt = $pdo->prepare("UPDATE blog SET title = :title, content = :content, image = :image, thumbnail = :thumbnail, created_at = :updated_at WHERE id = :id");
    $success = $stmt->execute([
        ':title' => $title,
        ':content' => $content,
        ':image' => $imagePath,
        ':thumbnail' => $thumbnailPath,
        ':updated_at' => $updated_at,
        ':id' => $blogId
    ]);

    if ($success) {
        echo "Blog updated successfully!";
        header("Location: blog_management.php");
        exit;
    } else {
        echo "Failed to update blog.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Blog</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            padding: 40px;
        }
        .edit-blog-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        form input[type="text"], form textarea, form input[type="file"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            transition: border-color 0.3s ease;
        }
        form input[type="text"]:focus, form textarea:focus {
            border-color: #007bff;
            outline: none;
        }
        form textarea {
            resize: vertical;
            min-height: 150px;
        }
        img {
            display: block;
            margin-bottom: 20px;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        button[type="submit"] {
            display: inline-block;
            padding: 10px 20px;
            background: linear-gradient(90deg, #007bff 0%, #0056b3 100%);
            border: none;
            color: #fff;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
            transition: background 0.3s ease, transform 0.2s;
        }
        button[type="submit"]:hover {
            background: linear-gradient(90deg, #0056b3 0%, #003f7f 100%);
            transform: translateY(-2px);
        }
        @media (max-width: 600px) {
            .edit-blog-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="edit-blog-container">
        <h2>Edit Blog</h2>
        <form method="post" enctype="multipart/form-data">
            <label>Title:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($blog['title']) ?>" required>

            <label>Content:</label>
            <textarea name="content" required><?= htmlspecialchars($blog['content']) ?></textarea>

            <label>Image:</label>
            <input type="file" name="image">
            <img src="/myphpproject/<?= $blog['image'] ?>" width="150">

            <label>Thumbnail:</label>
            <input type="file" name="thumbnail">
            <img src="/myphpproject/<?= $blog['thumbnail'] ?>" width="150">

            <button type="submit">Update Blog</button>
        </form>
    </div>
    <div class="back-link">
        <a href="/myphpproject/index.php?page=dashboard" class="btn btn-primary">⬅ Back to Admin Dashboard</a>
    </div>
</body>
</html>
