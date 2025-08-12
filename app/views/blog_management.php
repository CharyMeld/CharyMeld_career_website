<?php
// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include base URL and database connection
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

// Ensure $pdo is defined before use
if (!isset($pdo)) {
    die("Database connection failed. Please check database.php.");
}

// Fetch blogs from database
$stmt = $pdo->prepare("SELECT * FROM blog ORDER BY created_at DESC");
$stmt->execute();
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center mb-4">Manage Blogs</h2>
            <div class="d-flex justify-content-end mb-3">
                <a href="<?= BASE_URL; ?>app/views/add_blog.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Blog
                </a>
            </div>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($blogs as $blog): ?>
                    <tr>
                        <td><?= htmlspecialchars($blog['title']) ?></td>
                        <td><?= $blog['created_at'] ?></td>
                        <td>
                            <a href="<?= BASE_URL; ?>app/views/edit_blog.php?id=<?= $blog['id'] ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="<?= BASE_URL; ?>app/views/delete_blog.php?id=<?= $blog['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
