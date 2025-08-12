<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-10 rounded-xl shadow-lg max-w-md text-center">
        <h1 class="text-4xl font-bold text-red-500 mb-4">403</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Unauthorized Access</h2>
        <p class="text-gray-500 mb-6">You don't have permission to view this page.</p>
        <a href="/myphpproject/index.php?page=login" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Go to Login</a>
    </div>
</body>
</html>
