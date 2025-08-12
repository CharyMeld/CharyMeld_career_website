<?php
require_once __DIR__ . '/../../config/database.php'; // Include database connection

class User {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch user by email
    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Register a new user
    public function registerUser($fullname, $username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (fullname, username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fullname, $username, $email, $hashedPassword);
        return $stmt->execute();
    }
}
?>
