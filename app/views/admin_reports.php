
<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /myphpproject/index.php?page=login");
    exit();
}

$users_query = "SELECT id, username FROM users ORDER BY username ASC";
$users_stmt = $pdo->query($users_query);
$users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);

$user_filter = isset($_GET['user_id']) ? (int)$_GET['user_id'] : null;
$time_filter = $_GET['time_filter'] ?? 'all';
$current_date = date("Y-m-d");

$date_condition = "";
switch ($time_filter) {
    case 'weekly':
        $date_condition = "AND w.date >= DATE_SUB(:current_date, INTERVAL 7 DAY)";
        break;
    case 'monthly':
        $date_condition = "AND w.date >= DATE_SUB(:current_date, INTERVAL 1 MONTH)";
        break;
    case 'yearly':
        $date_condition = "AND w.date >= DATE_SUB(:current_date, INTERVAL 1 YEAR)";
        break;
    case 'all':
        $date_condition = "";
        break;
    default:
        $date_condition = "AND w.date = :current_date";
}

$work_report_query = "
    SELECT w.date, u.username, w.type_of_assignment, w.no_of_files_completed, w.challenges 
    FROM work_reports w
    JOIN users u ON w.user_id = u.id 
    WHERE 1=1 $date_condition
";

if ($user_filter) {
    $work_report_query .= " AND w.user_id = :user_id";
}
$work_report_query .= " ORDER BY w.date DESC";

$stmt = $pdo->prepare($work_report_query);
if (strpos($date_condition, ':current_date') !== false) {
    $stmt->bindValue(':current_date', $current_date);
}
if ($user_filter) {
    $stmt->bindValue(':user_id', $user_filter);
}
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['export_csv']) && $_GET['export_csv'] == 1) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="work_reports.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Date', 'User', 'Type of Assignment', 'Files Completed', 'Challenges']);

    foreach ($reports as $report) {
        fputcsv($output, [
            $report['date'],
            $report['username'],
            $report['type_of_assignment'],
            $report['no_of_files_completed'],
            $report['challenges'],
        ]);
    }

    fclose($output);
    exit();
}

?>
<style>
.container {
    max-width: 1100px;
    margin: auto;
    background-color: #f9fbfd;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.03);
}
h1.h2 {
    font-weight: 700;
    color: #1f2d3d;
}
form.bg-white {
    background-color: #ffffff;
    border: 1px solid #e4e8ef;
    border-radius: 12px;
    padding: 20px;
}
.form-label {
    font-weight: 600;
    color: #495057;
}
.form-select, select.form-select {
    max-width: 100%;
    padding: 10px 12px;
    border-radius: 6px;
    border: 1px solid #ced4da;
    transition: border-color 0.3s;
}
.form-select:focus {
    border-color: #007bff;
}
.apply-filters-btn {
    padding: 10px 16px;
    background: linear-gradient(90deg, #007bff 0%, #0056b3 100%);
    border: none;
    color: #fff;
    border-radius: 8px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
    transition: 0.3s;
    white-space: nowrap;
}
.apply-filters-btn:hover {
    background: linear-gradient(90deg, #0056b3 0%, #004080 100%);
}
.btn-success, .btn-primary {
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 600;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    white-space: nowrap;
}
.btn-success {
    background: linear-gradient(90deg, #28a745, #218838);
    border: none;
}
.btn-success:hover {
    background: linear-gradient(90deg, #218838, #1c682f);
}
.btn-primary {
    background: linear-gradient(90deg, #007bff, #0056b3);
    border: none;
}
.btn-primary:hover {
    background: linear-gradient(90deg, #0056b3, #003f7f);
}
.filter-row .col-md-4 {
    display: flex;
    flex-direction: column;
}
.filter-row .col-md-4 select {
    max-width: 100%;
}
.table-responsive {
    overflow-x: auto;
    border-radius: 10px;
}
.table {
    width: 100%;
    margin-top: 20px;
    border-collapse: separate;
    border-spacing: 0 10px;
}
.table thead th {
    background: linear-gradient(90deg, #0d6efd, #0a58ca);
    color: #fff;
    padding: 14px;
    text-align: center;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}
.table tbody td {
    background-color: #ffffff;
    padding: 12px 14px;
    vertical-align: middle;
}
.table tbody tr {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    border-radius: 8px;
    transition: 0.3s;
}
.table tbody tr:hover {
    background-color: #eef6ff;
}
.table td:nth-child(4) {
    font-weight: bold;
    color: #198754;
    text-align: center;
}
.badge.bg-secondary {
    background-color: #6c757d;
    color: #fff;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
}
.text-muted {
    color: #6c757d !important;
    font-style: italic;
}
.shadow, .shadow-sm {
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.04);
}
@media (max-width: 768px) {
    .container {
        padding: 20px;
    }
    h1.h2 {
        font-size: 22px;
    }
    .apply-filters-btn {
        width: 100%;
    }
}
</style>


<div class="container py-4">
    <main class="px-md-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 fw-bold">📊 All Users Work Reports</h1>
            <a href="index.php?page=admin_reports&export_csv=1" class="btn btn-success shadow">Export CSV</a>
        </div>

        <form method="GET" action="app/views/work_reports_table.php" class="bg-white p-4 rounded shadow-sm border mb-5">

            <div class="row g-4 filter-row">
                <div class="col-md-4">
                    <label class="form-label">User</label>
                    <select name="user_id" class="form-select">
                        <option value="">All Users</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id']; ?>" <?= ($user_filter == $user['id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($user['username']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Time Range</label>
                    <select name="time_filter" class="form-select">
                        <option value="all" <?= ($time_filter == 'all') ? 'selected' : ''; ?>>All Time</option>
                        <option value="daily" <?= ($time_filter == 'daily') ? 'selected' : ''; ?>>Today</option>
                        <option value="weekly" <?= ($time_filter == 'weekly') ? 'selected' : ''; ?>>Last 7 Days</option>
                        <option value="monthly" <?= ($time_filter == 'monthly') ? 'selected' : ''; ?>>Last Month</option>
                        <option value="yearly" <?= ($time_filter == 'yearly') ? 'selected' : ''; ?>>Last Year</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="apply-filters-btn">Apply Filters & View Report</button>
                </div>
            </div>
        </form>

        <div class="table-responsive shadow-sm">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>User</th>
                        <th>Type of Assignment</th>
                        <th>Files Completed</th>
                        <th>Challenges</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($reports) > 0): ?>
                        <?php foreach ($reports as $report): ?>
                            <tr>
                                <td><?= htmlspecialchars($report['date']); ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($report['username']); ?></span></td>
                                <td><?= htmlspecialchars($report['type_of_assignment']); ?></td>
                                <td class="fw-bold text-success text-center"><?= htmlspecialchars($report['no_of_files_completed']); ?></td>
                                <td><?= nl2br(htmlspecialchars($report['challenges'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No reports found for these filters.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
        <div class="text-center mt-4">
        <a href="/myphpproject/index.php?page=dashboard" class="btn btn-primary">⬅ Back to Dashboard</a>
        </div>
