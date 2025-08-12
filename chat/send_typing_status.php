<?php
require_once "../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $mysqli->real_escape_string($_POST['user'] ?? 'Guest');
    $typing = $_POST['typing'] ?? false;

    // Store typing status in the database (you could add a table to handle typing statuses)
    $timestamp = date('Y-m-d H:i:s');
    $mysqli->query("DELETE FROM typing_status WHERE user = '$user'"); // Remove previous status
    if ($typing) {
        $mysqli->query("INSERT INTO typing_status (user, typing, timestamp) VALUES ('$user', 1, '$timestamp')");
    }
}
?>
