<?php
require_once "../config/database.php";

$result = $mysqli->query("SELECT status FROM admin_status ORDER BY timestamp DESC LIMIT 1");
$adminStatus = $result->fetch_assoc();

if ($adminStatus) {
    echo json_encode([
        'status' => $adminStatus['status']
    ]);
} else {
    echo json_encode([
        'status' => 'offline'
    ]);
}
?>
