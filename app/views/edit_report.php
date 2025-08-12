<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: /myphpproject/index.php?page=unauthorized");
    exit();
}

$userId = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: /myphpproject/index.php?page=userdashboard");
    exit();
}

$reportId = $_GET['id'];

// Fetch the report to edit
$stmt = $pdo->prepare("SELECT * FROM work_reports WHERE id = :id AND user_id = :user_id");
$stmt->execute(['id' => $reportId, 'user_id' => $userId]);
$report = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$report) {
    echo "Report not found or you don't have permission.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type_of_assignment = $_POST['type_of_assignment'];
    $no_of_files_completed = $_POST['no_of_files_completed'];
    $challenges = $_POST['challenges'];

    $updateStmt = $pdo->prepare("UPDATE work_reports SET type_of_assignment = :type, no_of_files_completed = :files, challenges = :challenges WHERE id = :id AND user_id = :user_id");
    $updateStmt->execute([
        'type' => $type_of_assignment,
        'files' => $no_of_files_completed,
        'challenges' => $challenges,
        'id' => $reportId,
        'user_id' => $userId
    ]);

    header("Location: /myphpproject/index.php?page=userdashboard");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2>Edit Work Report</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Type of Assignment</label>
            <input type="text" name="type_of_assignment" class="form-control" value="<?= htmlspecialchars($report['type_of_assignment']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Number of Files Completed</label>
            <input type="number" name="no_of_files_completed" class="form-control" value="<?= htmlspecialchars($report['no_of_files_completed']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Challenges</label>
            <textarea name="challenges" class="form-control" rows="3"><?= htmlspecialchars($report['challenges']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Report</button>
        <a href="/myphpproject/index.php?page=userdashboard" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
