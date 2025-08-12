<?php
// ✅ Only start session if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../config/database.php";

// ✅ Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /myphpproject/index.php?page=login");
    exit();
}

$user_id = $_SESSION['user_id'];
$date = date("Y-m-d");

// ✅ Fetch attendance records
$query = "SELECT * FROM attendance WHERE user_id = :user_id AND date = :date";
$stmt = $pdo->prepare($query);
$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
$stmt->bindValue(":date", $date, PDO::PARAM_STR);
$stmt->execute();
$attendance = $stmt->fetch(PDO::FETCH_ASSOC);


// ✅ Handle Sign-in
if (isset($_POST['sign_in']) && !$attendance) {
    $sign_in_time = date("H:i:s");
    $insert_query = "INSERT INTO attendance (user_id, date, sign_in_time) VALUES (:user_id, :date, :sign_in_time)";
    $insert_stmt = $pdo->prepare($insert_query);
    $insert_stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $insert_stmt->bindValue(":date", $date, PDO::PARAM_STR);
    $insert_stmt->bindValue(":sign_in_time", $sign_in_time, PDO::PARAM_STR);

    if ($insert_stmt->execute()) {
        header("Location: /myphpproject/index.php?page=attendance_page&success=Signed in successfully");

        exit();
    } else {
        $error = "❌ Failed to sign in.";
    }
}

// ✅ Handle Sign-out
if (isset($_POST['sign_out']) && $attendance && !$attendance['sign_out_time']) {
    $sign_out_time = date("H:i:s");
    $update_query = "UPDATE attendance SET sign_out_time = :sign_out_time WHERE user_id = :user_id AND date = :date";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->bindValue(":sign_out_time", $sign_out_time, PDO::PARAM_STR);
    $update_stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $update_stmt->bindValue(":date", $date, PDO::PARAM_STR);

    if ($update_stmt->execute()) {
       header("Location: /myphpproject/index.php?page=attendance_page&success=Signed out successfully");

        exit();
    } else {
        $error = "❌ Failed to sign out.";
    }
}
?>

<?php include __DIR__ . "/header.php"; ?>

<style>
    /* Center the form container */
    .attendance-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #f4f7fc;
    }

    .attendance-card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 100%;
        max-width: 400px;
    }

    h2 {
        color: #333;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
        text-align: left;
    }

    label {
        font-weight: 600;
        color: #444;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: #f9f9f9;
    }

    .btn {
        width: 100%;
        padding: 12px;
        border-radius: 6px;
        font-weight: bold;
        transition: all 0.3s ease-in-out;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background-color: #a71d2a;
    }

    .alert {
        padding: 12px;
        border-radius: 6px;
        font-weight: bold;
        animation: fadeIn 0.5s ease-in-out;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="attendance-container">
    <div class="attendance-card">
        <h2>Daily Attendance</h2>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Date:</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($date); ?>" disabled>
            </div>
            
            <?php if (!$attendance): ?>
                <button type="submit" name="sign_in" class="btn btn-primary mt-3">✅ Sign In</button>
            <?php elseif (!$attendance['sign_out_time']): ?>
                <button type="submit" name="sign_out" class="btn btn-danger mt-3">🚀 Sign Out</button>
            <?php else: ?>
                <p class="mt-3">✅ You signed in at <strong><?= htmlspecialchars($attendance['sign_in_time']); ?></strong> and signed out at <strong><?= htmlspecialchars($attendance['sign_out_time']); ?></strong>.</p>
            <?php endif; ?>
        </form>
    </div>
</div>


<?php include __DIR__ . "/footer.php"; ?>
