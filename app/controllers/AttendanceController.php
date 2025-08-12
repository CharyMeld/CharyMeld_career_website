<?php
require_once __DIR__ . '/../../config/database.php'; // adjust path if needed

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class AttendanceController
{
    private $pdo;

    public function __construct($db)
    {
        $this->pdo = $db;
    }

    public function handleAttendance()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];

            if (isset($_POST['sign_in'])) {
                $message = $this->signIn($user_id);
                $_SESSION['attendance_message'] = $message;
            }

            if (isset($_POST['sign_out'])) {
                $message = $this->signOut($user_id);
                $_SESSION['attendance_message'] = $message;
            }

            // Redirect back to attendance page or wherever appropriate
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    public function signIn($user_id)
    {
        $today = date('Y-m-d');
        $now = date('Y-m-d H:i:s');

        $query = "SELECT * FROM attendance WHERE user_id = ? AND date = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$user_id, $today]);
        $existing = $stmt->fetch();

        if ($existing && $existing['sign_in_time'] !== null) {
            return "Already signed in today!";
        }

        if ($existing) {
            $query = "UPDATE attendance SET sign_in_time = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$now, $existing['id']]);
        } else {
            $query = "INSERT INTO attendance (user_id, date, sign_in_time) VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$user_id, $today, $now]);
        }

        return "Sign-in successful!";
    }

    public function signOut($user_id)
    {
        $today = date('Y-m-d');
        $now = date('Y-m-d H:i:s');

        $query = "SELECT * FROM attendance WHERE user_id = ? AND date = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$user_id, $today]);
        $record = $stmt->fetch();

        if (!$record || $record['sign_in_time'] === null) {
            return "You have not signed in today!";
        }

        if ($record['sign_out_time'] !== null) {
            return "Already signed out today!";
        }

        $query = "UPDATE attendance SET sign_out_time = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$now, $record['id']]);

        return "Sign-out successful!";
    }
}
?>
