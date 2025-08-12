<?php
// delete_report.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: /myphpproject/index.php?page=unauthorized");
    exit();
}

require_once __DIR__ . '/../../config/database.php';

if (isset($_GET['id'])) {
    $reportId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("DELETE FROM work_reports WHERE id = :id AND user_id = :user_id");
    $stmt->execute(['id' => $reportId, 'user_id' => $userId]);

    header("Location: /myphpproject/index.php?page=userdashboard");
    exit();
} else {
    header("Location: /myphpproject/index.php?page=userdashboard");
    exit();
}
