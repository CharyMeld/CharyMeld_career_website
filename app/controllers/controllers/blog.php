<?php
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/controllers/BlogController.php";

// ✅ Ensure `$conn` is passed to `BlogController`
$blogController = new BlogController($conn);
$blogs = $blogController->getAllBlogs();
?>

<?php include __DIR__ . "/header.php"; ?>

<div class="container mt-5">
    <h2>Blog Posts</h2>

    <?php if (empty($blogs)): ?>
        <p class="text-muted">No blog posts available.</p>
    <?php else: ?>
        <?php foreach ($blogs as $blog): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($blog['title']); ?></h5>
                    <p class="card-text"><?= htmlspecialchars(substr($blog['content'], 0, 100)); ?>...</p>
                    <a href="index.php?page=blog_details&id=<?= htmlspecialchars($blog['id']); ?>" class="btn btn-primary">Read More</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . "/footer.php"; ?>
