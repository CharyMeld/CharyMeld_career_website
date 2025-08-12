<?php
// Include your database connection file
require_once __DIR__ . "/../../config/database.php"; // Update path if needed
echo "Trying to load: " . __DIR__ . "/app/views/$page.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit();
}

$user_id = $_SESSION['user_id'];
$date = date("Y-m-d");

// Handle work report submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $work_details = $_POST['work_details'];
    
    if (empty($work_details)) {
        $error = "Please enter work details.";
    } else {
        $query = "INSERT INTO work_reports (user_id, date, work_details) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $user_id, $date, $work_details);
        
        if ($stmt->execute()) {
            header("Location: index.php?page=work_report&success=Work report submitted successfully");
            exit();
        } else {
            $error = "Failed to submit work report.";
        }
    }
}

// Fetch today's work report (if submitted)
$query = "SELECT * FROM work_reports WHERE user_id = ? AND date = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $user_id, $date);
$stmt->execute();
$result = $stmt->get_result();
$work_report = $result->fetch_assoc();
?>

<?php include __DIR__ . "/header.php"; ?>

<div class="container mt-5">
    <h2>Daily Work Report</h2>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"> <?= htmlspecialchars($_GET['success']); ?> </div>
    <?php endif; ?>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label>Date:</label>
            <input type="text" class="form-control" value="<?= $date; ?>" disabled>
        </div>
        <div class="form-group">
            <label>Work Details:</label>
            <textarea name="work_details" class="form-control" rows="5" required><?= $work_report['work_details'] ?? ''; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3" <?= $work_report ? 'disabled' : ''; ?>>Submit Report</button>
    </form>
</div>

<?php include __DIR__ . "/footer.php"; ?>
