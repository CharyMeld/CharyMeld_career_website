<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: /myphpproject/index.php?page=unauthorized");
    exit();
}

require_once __DIR__ . '/../../config/database.php';

$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'] ?? 'User';

$profileImage = !empty($_SESSION['profile_image']) 
    ? '/myphpproject/uploads/profile_images/' . $_SESSION['profile_image'] 
    : 'https://avatars.dicebear.com/api/initials/' . urlencode($userName) . '.svg';

$today = date('Y-m-d');
$signInDone = false;
$signOutDone = false;

$query = "SELECT sign_in_time, sign_out_time FROM attendance WHERE user_id = ? AND date = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$userId, $today]);
$attendance = $stmt->fetch();

if ($attendance) {
    $signInDone = !empty($attendance['sign_in_time']);
    $signOutDone = !empty($attendance['sign_out_time']);
}

$stmt = $pdo->prepare("SELECT * FROM work_reports WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 20");
$stmt->execute(['user_id' => $userId]);
$userReports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - <?php echo htmlspecialchars($userName); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            font-family: 'Segoe UI', sans-serif;
        }
        .profile-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 40px;
            transition: all 0.3s ease;
        }
        .profile-card:hover {
            transform: translateY(-5px);
        }
        .btn-custom, .btn-success, .btn-danger {
            padding: 10px 30px;
            border-radius: 50px;
            transition: all 0.3s;
        }
        .btn-success:hover { background-color: #28a745; color: #fff; }
        .btn-danger:hover { background-color: #c82333; color: #fff; }
        .btn-custom {
            background-color: #4e73df;
            color: #fff;
        }
        .btn-custom:hover {
            background-color: #2e59d9;
        }
        .form-section {
            background-color: #f8f9fc;
            border-radius: 15px;
            padding: 25px;
            margin-top: 30px;
        }
        .btn-group-actions button {
            display: inline-block;
            width: auto;
            margin-right: 10px;
        }
        input, textarea { border-radius: 10px !important; }
        table tr:hover { background-color: #f1f1f1; cursor: pointer; transition: 0.2s; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="profile-card text-center">
                <img src="<?php echo $profileImage; ?>" alt="Profile Image" class="profile-img mb-3" style="width:120px; height:120px; border-radius:50%; border: 3px solid #4e73df; object-fit:cover;">
                <h2>Hello, <?php echo htmlspecialchars($userName); ?></h2>
                <p class="text-muted mb-4">Your Employee Dashboard | Profile & Daily Reports</p>

                <?php if (isset($_GET['report']) && $_GET['report'] === 'success'): ?>
                    <div class="alert alert-success mt-3">Your work report has been submitted successfully!</div>
                <?php endif; ?>

                <form action="/myphpproject/index.php?page=upload_profile_image" method="POST" enctype="multipart/form-data" class="mb-4 d-flex gap-3 justify-content-center">
                    <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                    <input type="file" name="profile_image" accept="image/*" required>
                    <button type="submit" class="btn btn-custom">Upload Image</button>
                </form>

                <div class="form-section text-start">
                    <h5>Attendance</h5>
                    <?php if (isset($_GET['message'])): ?>
                        <div class="alert alert-info"><?php echo htmlspecialchars($_GET['message']); ?></div>
                    <?php endif; ?>

                    <div class="btn-group-actions">
                    <?php if (!$signInDone): ?>
                        <form method="POST" action="/myphpproject/app/actions/attendance_action.php">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
                            <button name="action" value="signin" class="btn btn-success">Sign In</button>
                        </form>
                    <?php elseif ($signInDone && !$signOutDone): ?>
                        <form method="POST" action="/myphpproject/app/actions/attendance_action.php">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
                            <button name="action" value="signout" class="btn btn-danger">Sign Out</button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-success mt-2">You have completed today's attendance.</div>
                    <?php endif; ?>
                    </div>
                </div>

                <div class="form-section text-start">
                    <h5>Submit Daily Work Report</h5>
                    <form action="/myphpproject/index.php?page=submit_work_report" method="POST">
                        <input type="hidden" name="user_id" value="<?= $userId; ?>">
                        <div class="mb-3">
                            <label>Type of Assignment</label>
                            <input type="text" name="type_of_assignment" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Number of Files Completed</label>
                            <input type="number" name="no_of_files_completed" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Challenges Faced</label>
                            <textarea name="challenges" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-custom">Submit Report</button>
                    </form>
                </div>

                <div class="report-list mt-5">
                    <h4>Your Work Reports</h4>
                    <?php if (empty($userReports)): ?>
                        <p class="text-muted">No reports submitted yet.</p>
                    <?php else: ?>
                        <table class="table table-striped mt-3">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Assignment Type</th>
                                    <th>Files Completed</th>
                                    <th>Challenges</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($userReports as $report): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($report['date']) ?></td>
                                        <td><?= htmlspecialchars($report['type_of_assignment']) ?></td>
                                        <td><?= htmlspecialchars($report['no_of_files_completed']) ?></td>
                                        <td><?= htmlspecialchars($report['challenges']) ?></td>
                                        <td>
                                        <a href="/myphpproject/index.php?page=edit_report&id=<?= $report['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="/myphpproject/index.php?page=delete_report&id=<?= $report['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this report?');">Delete</a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>

                <a href="/myphpproject/index.php?page=logout" class="btn btn-dark mt-4">Logout</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>