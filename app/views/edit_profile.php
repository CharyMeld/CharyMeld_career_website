<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// ✅ Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /myphpproject/index.php?page=login");
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Fetch user details securely
$query = "SELECT username, email, password, profile_image FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// ✅ Generate CSRF token (Prevent CSRF attacks)
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ✅ Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    // ✅ Update Profile
    if (isset($_POST['update_profile'])) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);

        if (empty($username) || empty($email)) {
            $error = "❌ All fields are required!";
        } else {
            $update_query = "UPDATE users SET username = ?, email = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ssi", $username, $email, $user_id);

            if ($update_stmt->execute()) {
                $_SESSION['username'] = $username;
                header("Location: /myphpproject/index.php?page=edit_profile&success=Profile updated successfully");
                exit();
            } else {
                $error = "❌ Failed to update profile. Error: " . $conn->error;
            }
        }
    }

    // ✅ Update Password
    if (isset($_POST['update_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $error = "❌ All fields are required!";
        } elseif (strlen($new_password) < 6) {
            $error = "⚠️ New password must be at least 6 characters long!";
        } elseif ($new_password !== $confirm_password) {
            $error = "❌ New passwords do not match!";
        } else {
            if (password_verify($current_password, $user['password'])) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_query = "UPDATE users SET password = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("si", $hashed_password, $user_id);

                if ($update_stmt->execute()) {
                    header("Location: /myphpproject/index.php?page=edit_profile&success=Password updated successfully");
                    exit();
                } else {
                    $error = "❌ Failed to update password.";
                }
            } else {
                $error = "⚠️ Current password is incorrect.";
            }
        }
    }

    // ✅ Update Profile Picture
    if (isset($_POST['update_picture']) && isset($_FILES['profile_picture'])) {
        $target_dir = "uploads/";
        $file_name = basename($_FILES["profile_picture"]["name"]);
        $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "gif"];
        $file_size = $_FILES["profile_picture"]["size"];
        $new_file_name = $target_dir . "profile_" . time() . "." . $imageFileType;

        if (!in_array($imageFileType, $allowed_types)) {
            $error = "❌ Only JPG, JPEG, PNG, and GIF files are allowed.";
        } elseif ($file_size > 2000000) { // Limit file size to 2MB
            $error = "⚠️ File size too large! Maximum size: 2MB.";
        } else {
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $new_file_name)) {
                $update_query = "UPDATE users SET profile_image = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("si", $new_file_name, $user_id);

                if ($update_stmt->execute()) {
                    header("Location: /myphpproject/index.php?page=edit_profile&success=Profile picture updated successfully");
                    exit();
                } else {
                    $error = "❌ Failed to update profile picture.";
                }
            } else {
                $error = "⚠️ Failed to upload profile picture.";
            }
        }
    }
}
?>

<?php include __DIR__ . "/header.php"; ?>

<div class="container mt-5">
    <h2>Edit Profile</h2>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"> <?= htmlspecialchars($_GET['success']); ?> </div>
    <?php endif; ?>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>

    <!-- Update Profile Form -->
    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
        
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
        </div>
        <button type="submit" name="update_profile" class="btn btn-primary mt-3">Update Profile</button>
    </form>

    <hr>

    <!-- Update Password Form -->
    <h2>Change Password</h2>
    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
        
        <div class="form-group">
            <label>Current Password:</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>New Password:</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Confirm New Password:</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" name="update_password" class="btn btn-warning mt-3">Update Password</button>
    </form>

    <hr>

    <!-- Upload Profile Picture Form -->
    <h2>Update Profile Picture</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
        
        <div class="form-group">
            <label>Choose a Profile Picture:</label>
            <input type="file" name="profile_picture" class="form-control" required>
        </div>
        <button type="submit" name="update_picture" class="btn btn-success mt-3">Upload Picture</button>
    </form>
</div>

<?php include __DIR__ . "/footer.php"; ?>
