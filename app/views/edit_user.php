<?php
// Start session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/database.php';

// ✅ Ensure user is logged in and is an admin
if (!isset($_SESSION['user_id']) || (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin')) {
    header("Location: /myphpproject/index.php?page=login");
    exit();
}

// ✅ Validate and sanitize user ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: /myphpproject/index.php?page=dashboard&error=Invalid user ID");
    exit();
}

$user_id = (int) $_GET['id'];

// ✅ Fetch user details securely
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(1, $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: /myphpproject/index.php?page=dashboard&error=User not found");
    exit();
}

// ✅ Generate CSRF token to prevent CSRF attacks
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ✅ Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    // ✅ Get and sanitize input values
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // ✅ Validate inputs
    if (empty($name) || empty($username) || empty($email) || empty($role)) {
        $error = "❌ All fields are required!";
    } else {
        // ✅ Hash password only if it's changed
        $password_sql = "";
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $password_sql = ", password = :password";
        }

        // ✅ Update user details securely
        $update_query = "UPDATE users SET name = :name, username = :username, email = :email, role = :role $password_sql WHERE id = :id";
        $update_stmt = $pdo->prepare($update_query);
        $update_stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $update_stmt->bindValue(":username", $username, PDO::PARAM_STR);
        $update_stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $update_stmt->bindValue(":role", $role, PDO::PARAM_STR);
        $update_stmt->bindValue(":id", $user_id, PDO::PARAM_INT);

        if (!empty($password)) {
            $update_stmt->bindValue(":password", $hashed_password, PDO::PARAM_STR);
        }

        if ($update_stmt->execute()) {
            $_SESSION['success_message'] = "✅ User updated successfully!";
            header("Location: /myphpproject/index.php?page=dashboard");
            exit();
        } else {
            $error = "❌ Failed to update user.";
        }
    }
}
?>


<?php include __DIR__ . "/header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-lg p-6 max-w-lg w-full">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4 text-center">Edit User</h2>

        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded-md mb-4 text-center">
                <?= htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded-md mb-4 text-center">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

            <!-- Name Field -->
            <div>
                <label class="block text-gray-600 font-medium">Full Name:</label>
                <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" 
                    value="<?= htmlspecialchars($user['name'] ?? ''); ?>" required>
            </div>

            <!-- Username Field -->
            <div>
                <label class="block text-gray-600 font-medium">Username:</label>
                <input type="text" name="username" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" 
                    value="<?= htmlspecialchars($user['username']); ?>" required>
            </div>

            <!-- Email Field -->
            <div>
                <label class="block text-gray-600 font-medium">Email:</label>
                <input type="email" name="email" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" 
                    value="<?= htmlspecialchars($user['email']); ?>" required>
            </div>

            <!-- Password Field -->
            <div>
                <label class="block text-gray-600 font-medium">Password:</label>
                <input type="password" name="password" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" 
                    placeholder="Enter new password (leave blank to keep current password)">
            </div>

            <!-- Role Selection -->
            <div>
                <label class="block text-gray-600 font-medium">Role:</label>
                <select name="role" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                    <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="employee" <?= ($user['role'] == 'employee') ? 'selected' : ''; ?>>employee</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-200">
                Update User
            </button>
        </form>
    </div>

</body>
</html>


<?php include __DIR__ . "/footer.php"; ?>
