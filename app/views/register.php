<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to the CSS file -->

</head>
<body>

<header>
   <?php include __DIR__ . "/header.php"; ?>
</header>

<div class="register-container">
    <div class="register-box">
        <h2>Register</h2>

        <!-- Display Messages -->
        <?php if (isset($_SESSION['register_error'])): ?>
            <div class="error-message"><?= $_SESSION['register_error']; unset($_SESSION['register_error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['register_success'])): ?>
            <div class="success-message"><?= $_SESSION['register_success']; unset($_SESSION['register_success']); ?></div>
        <?php endif; ?>

    <form action="/myphpproject/index.php?page=auth_register" method="POST" class="space-y-4">

    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

    <div class="input-group">
        <label>Full Name:</label>
        <input type="text" name="name" required>
    </div>
    <div class="input-group">
        <label>Username:</label>
        <input type="text" name="username" required>
    </div>
    <div class="input-group">
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>
    <div class="input-group">
        <label>Role:</label>
        <select name="role" required>
            <option value="">-- Select Role --</option>
            <option value="admin">Admin</option>
            <option value="employee">Employee</option>
        </select>
    </div>
    <div class="input-group">
        <label>Password:</label>
        <input type="password" name="password" required>
    </div>
    <div class="input-group">
        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required>
    </div>
    <button type="submit" name="register" class="register-btn">Register</button>
</form>

    </div>
</div>

<style>
/* Reset and Global Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

/* Keep header and footer in place */
header, footer {
    width: 100%;
    background: #BDB395; /* Match theme color */
    color: white;
    padding: 15px;
    text-align: center;
}

/* Proper layout without overlapping header */
.register-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: calc(100vh - 100px); /* Subtract header & footer height */
    padding: 20px;
    margin-top: 60px; /* Push form down */
}

/* Registration Box */
.register-box {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 100%;
    max-width: 400px;
}


/* Title */
.register-box h2 {
    color: #333;
    margin-bottom: 20px;
}

/* Input Group */
.input-group {
    margin-bottom: 15px;
    text-align: left;
}

.input-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #555;
}

.input-group input, 
.input-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    transition: 0.3s;
}

/* Input Focus Effect */
.input-group input:focus, 
.input-group select:focus {
    border-color: #BDB395;
    outline: none;
    box-shadow: 0px 0px 5px rgba(189, 179, 149, 0.5);
}

/* Register Button */
.register-btn {
    width: 100%;
    padding: 12px;
    background: #BDB395;
    color: white;
    font-size: 18px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.register-btn:hover {
    background: #9E8D6B;
    transform: scale(1.05);
}

/* Success & Error Messages */
.success-message {
    background: #4CAF50;
    color: white;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 10px;
}

.error-message {
    background: #E74C3C;
    color: white;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 10px;
}


</style>
</body>
</html>



<footer>
   <?php include __DIR__ . "/footer.php"; ?>
</footer>




