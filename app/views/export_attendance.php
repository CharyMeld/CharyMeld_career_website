<?php
// export_attendance_pdf.php
require 'db_connect.php';
require_once 'tcpdf/tcpdf.php'; // Make sure TCPDF library is included in your project

$filter = $_GET['filter'] ?? 'daily';
$selected_user = $_GET['user_id'] ?? '';

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
    $filterCondition .= " AND attendance.user_id = :user_id";
}

$query = "SELECT attendance.*, users.name FROM attendance JOIN users ON attendance.user_id = users.id WHERE 1=1 $filterCondition ORDER BY date DESC";
$stmt = $pdo->prepare($query);
if (!empty($selected_user)) {
    $stmt->bindParam(':user_id', $selected_user, PDO::PARAM_INT);
}
$stmt->execute();

$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Attendance System');
$pdf->SetTitle('Attendance Report');
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

$html = '<h2>Attendance Report</h2><table border="1" cellpadding="4"><tr><th>User Name</th><th>Date</th><th>Sign In</th><th>Sign Out</th><th>Total Hours</th></tr>';

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $signin = strtotime($row['sign_in_time']);
    $signout = strtotime($row['sign_out_time']);
    $hours = $signout > $signin ? round(($signout - $signin) / 3600, 2) : 0;
    $html .= '<tr><td>' . htmlspecialchars($row['name']) . '</td><td>' . $row['date'] . '</td><td>' . $row['sign_in_time'] . '</td><td>' . $row['sign_out_time'] . '</td><td>' . $hours . ' hrs</td></tr>';
}

$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('attendance_report.pdf', 'D');
exit;
