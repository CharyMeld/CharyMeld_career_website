<?php
include 'db.php'; // database connection

$result = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");

echo "<h2>Assigned Tasks</h2>";
echo "<table border='1' cellpadding='10'>
<tr>
    <th>ID</th>
    <th>Employee ID</th>
    <th>Title</th>
    <th>Description</th>
    <th>Status</th>
    <th>Created At</th>
</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['employee_id']}</td>
        <td>{$row['title']}</td>
        <td>{$row['description']}</td>
        <td>{$row['status']}</td>
        <td>{$row['created_at']}</td>
    </tr>";
}
echo "</table>";
?>

