<?php
require_once __DIR__ . "/../../config/database.php";

class Blog {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo; // Make sure we're consistently using $this->conn
    }

    // ✅ Fetch all blogs
    public function fetchAllBlogs() {
        $query = "SELECT * FROM blog";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Insert a new blog post
    public function createBlog($title, $content, $imagePath, $thumbnailPath) {
        $query = "INSERT INTO blog (title, content, image, thumbnail) VALUES (:title, :content, :image, :thumbnail)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":image", $imagePath);
        $stmt->bindParam(":thumbnail", $thumbnailPath);
        
        return $stmt->execute();
    }

    // ✅ Get latest blogs (limit 20 by default)
    public function getLatestBlogs($limit = 20) {
        $stmt = $this->conn->prepare("SELECT * FROM blog ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCommentsByPostId($postId) {
    $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC");
    $stmt->execute([$postId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function addComment($postId, $comment, $username) {
    $stmt = $this->pdo->prepare("INSERT INTO comments (post_id, username, comment) VALUES (?, ?, ?)");
    $stmt->execute([$postId, $username, $comment]);
}

}
?>

