<?php
// Include DB connection and session check if needed
include 'db.php'; // Adjust if you have a db connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $task_title = $_POST['task_title'];
    $task_description = $_POST['task_description'];

    $stmt = $conn->prepare("INSERT INTO tasks (employee_id, title, description, status) VALUES (?, ?, ?, 'Pending')");
    $stmt->bind_param("iss", $employee_id, $task_title, $task_description);
    $stmt->execute();
    echo "<div class='alert alert-success'>Task Assigned!</div>";
}
?>

<h2>Assign Task</h2>
<form method="POST">
    <label>Employee ID:</label>
    <input type="number" name="employee_id" required><br>

    <label>Task Title:</label>
    <input type="text" name="task_title" required><br>

    <label>Description:</label>
    <textarea name="task_description" required></textarea><br>

    <button type="submit">Assign Task</button>
</form>

