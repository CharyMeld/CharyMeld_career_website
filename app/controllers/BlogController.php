<?php
require_once __DIR__ . "/../models/Blog.php";

class BlogController {
    private $pdo;
    private $blog;

    public function __construct($pdo) {
        if (!$pdo) {
            die("❌ Database connection not found in BlogController!");
        }
        $this->pdo = $pdo;
        $this->blog = new Blog($pdo);
    }

    // ✅ Fetch all blogs with error handling
    public function getAllBlogs() {
        $blogs = $this->blog->fetchAllBlogs();
        
        if (!$blogs) {
            error_log("⚠️ No blogs found or database error.");
            return [];
        }
        return $blogs;
    }

    // ✅ Create a new blog post
    public function createBlog($title, $content, $imagePath = null, $thumbnailPath = null) {
        if (empty($title) || empty($content)) {
            return "⚠️ Error: Title and content are required!";
        }

        // Sanitize inputs
        $title = htmlspecialchars(strip_tags($title));
        $content = htmlspecialchars(strip_tags($content));

        // Call the Blog model to insert the new blog
        $result = $this->blog->createBlog($title, $content, $imagePath, $thumbnailPath);

        if ($result) {
            return "✅ Blog post created successfully!";
        } else {
            return "❌ Error: Could not create blog post.";
        }
    }

    // ✅ Get latest blogs
    public function getLatestBlogs($limit = 20) {
        return $this->blog->getLatestBlogs($limit);
    }

    // ✅ Like a blog post (Updated for 'blog' table)
    public function likeBlog($blogId) {
        $stmt = $this->pdo->prepare("UPDATE blog SET likes = likes + 1 WHERE id = ?");
        return $stmt->execute([$blogId]);
    }

    // ✅ Get comments for a blog post
    public function getCommentsForBlog($blogId) {
        $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE blog_id = ? ORDER BY created_at DESC");
        $stmt->execute([$blogId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Get a single blog post by ID (Updated for 'blog' table)
    public function getBlogById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM blog WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
