<?php
require_once "../config/database.php";

// Fetch the typing status from the database
$result = $mysqli->query("SELECT user FROM typing_status WHERE typing = 1 LIMIT 1");
$typingStatus = $result->fetch_assoc();

if ($typingStatus) {
    echo json_encode([
        'user' => $typingStatus['user'],
        'typing' => true
    ]);
} else {
    echo json_encode([
        'user' => null,
        'typing' => false
    ]);
}
?>
