<?php
// list_reports.php - List all saved attendance reports

$reportsDir = __DIR__ . '/reports/';
$files = glob($reportsDir . 'attendance_report_*.pdf');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Reports List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Attendance Reports List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Report Name</th>
                <th>Date Created</th>
                <th>Download</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($files) > 0): ?>
            <?php foreach ($files as $file): ?>
                <tr>
                    <td><?php echo basename($file); ?></td>
                    <td><?php echo date("Y-m-d H:i:s", filemtime($file)); ?></td>
                    <td><a href="reports/<?php echo basename($file); ?>" target="_blank" class="btn btn-success btn-sm">Download</a></td>
                    <td>
                        <form method="post" action="delete_report.php" onsubmit="return confirm('Are you sure you want to delete this report?');">
                            <input type="hidden" name="file" value="<?php echo basename($file); ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">No reports found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
// delete_report.php (handle deletion)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file'])) {
    $fileToDelete = __DIR__ . '/reports/' . basename($_POST['file']);
    if (file_exists($fileToDelete)) {
        unlink($fileToDelete);
        header('Location: list_reports.php');
        exit;
    }
}