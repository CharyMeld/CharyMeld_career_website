<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: /index.php?page=unauthorized");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../../config/database.php';

    $reportId = $_POST['report_id'] ?? null;
    $newStatus = $_POST['new_status'] ?? null;
    $userId = $_SESSION['user_id'];

    if ($reportId && in_array($newStatus, ['Pending', 'Success'])) {
        // Confirm the user owns this report
        $stmt = $pdo->prepare("SELECT id FROM work_reports WHERE id = ? AND user_id = ?");
        $stmt->execute([$reportId, $userId]);
        $report = $stmt->fetch();

        if ($report) {
            $updateStmt = $pdo->prepare("UPDATE work_reports SET status = ? WHERE id = ?");
            $updateStmt->execute([$newStatus, $reportId]);

            header("Location: /index.php?page=user_dashboard&message=Report status updated successfully");
            exit();
        } else {
            header("Location: /index.php?page=user_dashboard&message=Unauthorized action");
            exit();
        }
    } else {
        header("Location: /index.php?page=user_dashboard&message=Invalid request");
        exit();
    }
} else {
    header("Location: /index.php?page=user_dashboard");
    exit();
}
?>

