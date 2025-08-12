<?php
require_once __DIR__ . '/../controllers/AttendanceController.php';
require_once __DIR__ . '/../../config/database.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialize Attendance Controller
$attendanceController = new AttendanceController($pdo);

// Get the user_id (either from session or hidden form input)
$user_id = $_SESSION['user_id'] ?? $_POST['user_id'] ?? null;

if (!$user_id) {
    // Redirect with error if user_id is missing
    header("Location: /myphpproject/app/view/attendance_page.php?message=" . urlencode("User not found!"));
    exit;
}

// Check the action from form submission
$action = $_POST['action'] ?? null;

if ($action === 'signin') {
    $message = $attendanceController->signIn($user_id);
} elseif ($action === 'signout') {
    $message = $attendanceController->signOut($user_id);
} else {
    $message = "Invalid attendance action!";
}

// Redirect back to attendance page with the message
header("Location: /myphpproject/app/view/attendance_page.php?message=" . urlencode($message));
exit();
?>
