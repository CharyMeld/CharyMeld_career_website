<?php 
include 'app/views/partials/header.php'; 
require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/app/controllers/BlogController.php';

// Fetch the latest blogs
$blogController = new BlogController($pdo);
$blogs = $blogController->getLatestBlogs();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #f8f9fa;
            margin: 0;
            padding-top: 80px; /* Ensures content doesn't overlap with header */
            text-align: center;
        }
        .hero {
            background: url('/myphpproject/public/images/services-bg.jpg') no-repeat center center/cover;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            z-index: 2;
            margin-top: 50px; /* Creates space below header */
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* Ensures 4 per row */
            gap: 20px;
            justify-content: center;
        }
        @media (max-width: 1024px) {
            .grid {
                grid-template-columns: repeat(3, 1fr); /* 3 per row on tablets */
            }
        }
        @media (max-width: 768px) {
            .grid {
                grid-template-columns: repeat(2, 1fr); /* 2 per row on small screens */
            }
        }
        @media (max-width: 480px) {
            .grid {
                grid-template-columns: repeat(1, 1fr); /* 1 per row on mobile */
            }
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: 0.3s;
            text-align: left;
        }
        .card:hover {
            transform: scale(1.03);
        }
        .card img {
            width: 100%;
            height: 180px; /* Adjusted to maintain uniform size */
            object-fit: cover;
        }
        .card-body {
            padding: 15px;
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 0.9rem;
            color: #555;
            min-height: 60px;
        }
        .like-btn {
            cursor: pointer; 
            color: blue; 
            text-decoration: underline;
            display: inline-block;
            margin-top: 5px;
        }
        .like-btn:hover {
            text-decoration: none;
            color: darkblue;
        }
        .btn {
            display: inline-block;
            padding: 8px 12px;
            background: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="hero">
        <h1>Latest Blogs</h1>
        </header>
        <h2></h2>
        <div class="grid">
            <?php if (!empty($blogs)) : ?>
                <?php foreach ($blogs as $blog) : ?>
                    <div class="card">
                        <?php if (!empty($blog['thumbnail'])): ?>
                            <img src="<?= htmlspecialchars($blog['thumbnail']) ?>" alt="Blog Thumbnail">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($blog['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars(substr(strip_tags($blog['content']), 0, 100)) ?>...</p>
                            <button class="like-button" data-blog-id="<?= $blog['id']; ?>">👍 Like</button>
                            <span class="like-count"><?= $blog['likes']; ?></span>

                            <br><br>
                            <a href="/myphpproject/index.php?page=blog_detail&id=<?= intval($blog['id']) ?>" class="btn">Read More</a>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No blog posts found.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
    $(document).ready(function() {
      $(".like-btn").click(function() {
    var postId = $(this).data("id");
    var $likeBtn = $(this);
    var $likeCount = $("#like-count");

    $.ajax({
        url: '/myphpproject/app/controllers/LikeController.php',
        type: 'POST',
        data: { post_id: postId },  // ✅ Send form data (not JSON)
        success: function(response) {
            console.log("Server Response:", response);

            if (response.success) {
                $likeCount.text(response.new_likes);
                $likeBtn.addClass('like-anim');
                setTimeout(() => { $likeBtn.removeClass('like-anim'); }, 300);
            } else {
                alert('Failed to like: ' + response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error:", textStatus, errorThrown);
            alert("An error occurred while processing your request.");
        }
    });
});



    </script>
<?php include __DIR__ . "/footer.php"; ?>
</body>
</html>
