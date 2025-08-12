<?php
require_once __DIR__ . '/../../config/database.php';

class WorkReportController {
    public function submitReport() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /myphpproject/index.php?page=login");
            exit();
        }

        global $pdo;

        $user_id = $_SESSION['user_id'];
        $type_of_assignment = $_POST['type_of_assignment'] ?? '';
        $no_of_files_completed = $_POST['no_of_files_completed'] ?? 0;
        $challenges = $_POST['challenges'] ?? '';

        $stmt = $pdo->prepare("INSERT INTO work_reports (user_id, type_of_assignment, no_of_files_completed, challenges, date, created_at) VALUES (:user_id, :type_of_assignment, :no_of_files_completed, :challenges, NOW(), NOW())");
        $stmt->execute([
            'user_id' => $user_id,
            'type_of_assignment' => $type_of_assignment,
            'no_of_files_completed' => $no_of_files_completed,
            'challenges' => $challenges
        ]);

        header("Location: /myphpproject/index.php?page=userdashboard&report=success");
        exit();
    }
}
