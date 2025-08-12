<?php
// attendance_report.php - Complete attendance report page with report generation, list & delete

require_once __DIR__ . '/../../tcpdf/tcpdf.php';
require_once __DIR__ . '/../../config/database.php';

// Auto-clean old reports (older than 7 days)
$reportDir = __DIR__ . '/../../reports/';
if (!is_dir($reportDir)) {
    mkdir($reportDir, 0777, true);
}
foreach (glob($reportDir . 'attendance_report_*.pdf') as $oldFile) {
    if (filemtime($oldFile) < strtotime('-7 days')) {
        unlink($oldFile);
    }
}

// Handle report generation if requested
if (isset($_POST['generate_report'])) {
    $filter = $_POST['filter'] ?? 'daily';
    $selected_user = $_POST['user_id'] ?? '';

    $filterCondition = "";
    switch ($filter) {
        case 'daily':
            $filterCondition = "AND DATE(date) = CURDATE()";
            break;
        case 'weekly':
            $filterCondition = "AND YEARWEEK(date, 1) = YEARWEEK(CURDATE(), 1)";
            break;
        case 'monthly':
            $filterCondition = "AND MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())";
            break;
        case 'yearly':
            $filterCondition = "AND YEAR(date) = YEAR(CURDATE())";
            break;
    }

    if (!empty($selected_user)) {
        $filterCondition .= " AND attendance.user_id = '" . $selected_user . "'";
    }

    $query = "SELECT attendance.*, users.name FROM attendance 
              JOIN users ON attendance.user_id = users.id 
              WHERE 1=1 $filterCondition 
              ORDER BY date DESC";
    $result = $pdo->query($query);

    // Generate PDF
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);
    $html = '<h2>Attendance Report</h2>
             <table border="1" cellpadding="5">
             <tr><th>User Name</th><th>Date</th><th>Sign In</th><th>Sign Out</th><th>Hours</th></tr>';

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $signin = strtotime($row['sign_in_time']);
        $signout = strtotime($row['sign_out_time']);
        $hours = ($signout > $signin) ? round(($signout - $signin) / 3600, 2) : 0;
        $html .= '<tr>
                    <td>' . htmlspecialchars($row['name']) . '</td>
                    <td>' . htmlspecialchars($row['date']) . '</td>
                    <td>' . htmlspecialchars($row['sign_in_time']) . '</td>
                    <td>' . htmlspecialchars($row['sign_out_time']) . '</td>
                    <td>' . $hours . ' hrs</td>
                  </tr>';
    }
    $html .= '</table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    $reportFileName = 'attendance_report_' . date('Ymd_His') . '.pdf';
    $savePath = $reportDir . $reportFileName;
    $pdf->Output($savePath, 'F');

    // Redirect the user to download/view the PDF
    $webFilePath = '../../reports/' . $reportFileName;
    echo "<script>alert('Attendance report generated successfully!'); window.location.href='$webFilePath';</script>";
    exit;
}

// Display attendance report generation form (optional UI part)
$users = $pdo->query("SELECT id, name FROM users")->fetchAll(PDO::FETCH_ASSOC);
$files = glob($reportDir . 'attendance_report_*.pdf');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Generate Attendance Report</h2>
    <form method="post" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label>Filter:</label>
                <select name="filter" class="form-select">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>
            <div class="col-md-4">
                <label>Select User (Optional):</label>
                <select name="user_id" class="form-select">
                    <option value="">All Users</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 align-self-end">
                <button type="submit" name="generate_report" class="btn btn-primary">Generate Report</button>
            </div>
        </div>
    </form>

    <h3>Generated Reports</h3>
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
                        <form method="post" action="attendance_report.php" onsubmit="return confirm('Delete this report?');">
                            <input type="hidden" name="delete_file" value="<?php echo basename($file); ?>">
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
// Handle delete file
if (isset($_POST['delete_file'])) {
    $deleteFile = $reportDir . basename($_POST['delete_file']);
    if (file_exists($deleteFile)) {
        unlink($deleteFile);
        echo "<script>alert('Report deleted successfully!'); window.location.href='attendance_report.php';</script>";
    }
}
