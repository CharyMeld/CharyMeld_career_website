<?php
require_once "../config/database.php";

// You can change this to 'online' when the admin logs in and 'offline' when they log out
$status = 'online'; // Or 'offline'

$mysqli->query("INSERT INTO admin_status (status, timestamp) VALUES ('$status', NOW())");
?>
