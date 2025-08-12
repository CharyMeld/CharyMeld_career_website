<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/config.php';

$current_date = date("Y-m-d");

if (isset($_SESSION['success_message'])) {
    echo "<div class='alert alert-success text-center fw-bold'>
            {$_SESSION['success_message']}
          </div>";
    unset($_SESSION['success_message']);
}

// Filter handling
$where = [];
$params = [];

if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
    $where[] = 'w.date BETWEEN :start_date AND :end_date';
    $params['start_date'] = $_GET['start_date'];
    $params['end_date'] = $_GET['end_date'];
}

if (!empty($_GET['user_id'])) {
    $where[] = 'w.user_id = :user_id';
    $params['user_id'] = $_GET['user_id'];
}

if (!empty($_GET['report_type'])) {
    $where[] = 'w.type_of_assignment = :report_type';
    $params['report_type'] = $_GET['report_type'];
}

$whereClause = '';
if (!empty($where)) {
    $whereClause = 'WHERE ' . implode(' AND ', $where);
}

$sql = "
    SELECT w.*, u.name AS user_name 
    FROM work_reports w
    JOIN users u ON w.user_id = u.id 
    $whereClause 
    ORDER BY w.date DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

$usersStmt = $pdo->query("SELECT id, name FROM users");
$users = $usersStmt->fetchAll(PDO::FETCH_ASSOC);

// Handle CSV Export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="work_reports_' . date('Ymd_His') . '.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Date', 'User', 'Type of Assignment', 'No. of Files Completed', 'Challenges']);

    foreach ($reports as $report) {
        fputcsv($output, [
            $report['date'],
            $report['user_name'],
            $report['type_of_assignment'],
            $report['no_of_files_completed'],
            str_replace(["\r", "\n"], ' ', $report['challenges']),
        ]);
    }

    fclose($output);
    exit;
}
?>

<style>
.page-container {
    background-color: #f8fbfd;
    padding: 40px;
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
    width: 90%;
    margin: 40px auto;
    border: 1px solid #e3e8ef;
}
.page-title {
    font-weight: 700;
    color: #1f2d3d;
    margin-bottom: 30px;
    font-size: 28px;
}
.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
}
.table thead th {
    background: linear-gradient(90deg, #0d6efd, #0a58ca);
    color: #fff;
    text-align: center;
    padding: 14px;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}
.table tbody td {
    background-color: #ffffff;
    padding: 12px 14px;
    vertical-align: middle;
}
.table tbody tr {
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    border-radius: 8px;
}
.table tbody tr:hover {
    background-color: #eaf6ff;
    transition: background-color 0.3s;
}
.table td:nth-child(4) {
    font-weight: bold;
    color: #198754;
    text-align: center;
}
.btn-export {
    background: linear-gradient(90deg, #28a745, #218838);
    border: none;
    color: white;
    padding: 10px 22px;
    border-radius: 8px;
    font-weight: 600;
    transition: 0.3s;
    box-shadow: 0 4px 12px rgba(40,167,69,0.2);
}
.btn-export:hover {
    background: linear-gradient(90deg, #218838, #19692c);
}
.back-link {
    text-align: center;
    margin-top: 35px;
}
.back-link .btn {
    padding: 10px 22px;
    font-weight: 600;
    border-radius: 8px;
}
.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
    font-weight: 600;
}
@media (max-width: 768px) {
    .page-container {
        width: 100%;
        padding: 20px;
    }
    .page-title {
        font-size: 22px;
    }
}
</style>


<div class="container page-container mt-5"> 
    <h3 class="page-title">📊 Filtered Work Reports Overview</h3>

    <div class="d-flex justify-content-end mb-3">
        <a href="?<?= http_build_query($_GET) ?>&export=csv" class="btn btn-export">📥 Export as CSV</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Type</th>
                <th>Files Completed</th>
                <th>Challenges</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($reports) > 0): ?>
            <?php foreach ($reports as $report): ?>
                <tr>
                    <td><?= htmlspecialchars($report['date']) ?></td>
                    <td><?= htmlspecialchars($report['user_name']) ?></td>
                    <td><?= htmlspecialchars($report['type_of_assignment']) ?></td>
                    <td class="fw-bold text-success text-center"> <?= htmlspecialchars($report['no_of_files_completed']) ?></td>
                    <td><?= nl2br(htmlspecialchars($report['challenges'])) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center text-muted">No reports found for the selected filters.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="back-link">
        <a href="/myphpproject/index.php?page=admin_reports" class="btn btn-primary">⬅ Back to Admin Reports</a>
    </div>
</div>
