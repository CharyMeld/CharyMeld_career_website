<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = $_GET['message'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container text-center">
        <h1 class="mb-4">Attendance Portal</h1>

        <?php if (!empty($message)): ?>
            <div class="alert alert-info">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php else: ?>
            <div class="alert alert-secondary">
                No recent attendance action recorded.
            </div>
        <?php endif; ?>

        <a href="/myphpproject/index.php?page=dashboard" class="btn btn-primary mt-4">Back to Dashboard</a>
        <a href="/myphpproject/index.php?page=attendance" class="btn btn-outline-success mt-4 ms-2">Go to Attendance Page</a>
    </div>
</body>
</html>
