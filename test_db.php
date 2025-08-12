<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$host = "localhost";
$username = "u701480031_teamodigitals";
$password = "@TeamOsolutions2025";
$database = "u701480031_admindashboard";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users LIMIT 5";  // Change "users" to your actual table
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<pre>";
        print_r($row);
        echo "</pre>";
    }
} else {
    echo "No records found!";
}
?>
