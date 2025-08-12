<?php

class UserController {
    private $conn;

    public function __construct() {
        $host = 'localhost';
        $db = 'u701480031_admindashboard';
        $user = 'u701480031_teamodigitals';
        $pass = '@TeamOsolutions2025';

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getUserDetails($userId) {
        $stmt = $this->conn->prepare("SELECT id, full_name, email, role FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTodayAttendance($userId) {
        $today = date('Y-m-d');
        $stmt = $this->conn->prepare("SELECT * FROM attendance WHERE user_id = :user_id AND date = :today");
        $stmt->execute([
            'user_id' => $userId,
            'today' => $today
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserReports($userId) {
        $stmt = $this->conn->prepare("SELECT title, description, created_at FROM reports WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAssignedTasks($userId) {
        $stmt = $this->conn->prepare("SELECT title, description, due_date FROM tasks WHERE assigned_to = :user_id ORDER BY due_date ASC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

