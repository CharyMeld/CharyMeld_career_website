<?php include 'app/views/partials/header.php'; ?>
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

//  If user visits "dashboard" page, load dashboard directly without redirect
if (isset($_GET['page']) && $_GET['page'] === 'dashboard' && isset($_SESSION['role'])) {
    // Don't redirect — just continue to load the dashboard page
    // Unless they are employee, then redirect to userdashboard
    if ($_SESSION['role'] === 'employee') {
        header("Location: /myphpproject/index.php?page=userdashboard");
        exit();
    }
}




require_once __DIR__ . '/../helpers/csrf.php';
$flash_messages = get_flash_messages();
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const flashMessages = <?php echo json_encode($flash_messages); ?>;
    flashMessages.forEach(msg => {
        Swal.fire({
            icon: msg.type,
            text: msg.message,
            showConfirmButton: false,
            timer: 3000,
            toast: true,
            position: 'top-end'
        });
    });
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | My PHP Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-300 flex justify-center">
    <div class="w-full max-w-md mt-24 p-10 space-y-8 bg-white shadow-2xl rounded-2xl">
        <div class="space-y-3">
            <h2 class="text-3xl font-bold text-center text-gray-700">Welcome Back</h2>
            <p class="text-base text-center text-gray-500">Please sign in to continue</p>
        </div>

        <!-- Display Login Error Messages -->
        <?php if (isset($_SESSION['login_error'])): ?>
            <p class="p-3 text-center text-red-600 bg-red-100 border border-red-200 rounded-lg">
                <?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
            </p>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="/myphpproject/index.php?page=auth_login" method="POST" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-600">Email Address</label>
                <input type="email" name="email" required class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-indigo-300 focus:outline-none" placeholder="Enter your email">
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-600">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-indigo-300 focus:outline-none" placeholder="Enter your password">
            </div>

            <button type="submit" name="login" class="w-full px-4 py-3 text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition duration-300 focus:ring-2 focus:ring-indigo-300">Login</button>
        </form>
    </div>
</body>
</html>

