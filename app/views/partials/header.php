<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// header.php
require_once('C:/myxamppTeamOProject/htdocs/myphpproject/config/database.php');

// Use logo from session if available, otherwise default logo
$logoPath = $_SESSION['logo'] ?? "/myphpproject/public/images/default-logo.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TDS</title>

    <link rel="icon" type="image/x-icon" href="/myphpproject/public/images/favicon.ico">
    <link rel="stylesheet" href="/myphpproject/public/css/styles.css">
    <link rel="stylesheet" href="/myphpproject/public/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/myphpproject/public/assets/fontawesome/css/all.min.css">
    <script src="/myphpproject/public/js/dashboard.js" defer></script>

    <style>
        body { margin: 0; padding: 0; background-color: #DBDBC3; font-family: Arial, sans-serif; }
        header { width: 100%; position: fixed; top: 0; z-index: 1000; }
        .header-flex { display: flex; align-items: center; justify-content: space-between; background-color: #8A8A7B; padding: 15px 20px; color: white; }
        .logo-upload img { width: 60px; height: 60px; cursor: pointer; border-radius: 50%; border: 2px solid white; }
        .logo-upload input[type="file"] { display: none; }
        nav ul { display: flex; list-style: none; margin: 0; padding: 0; }
        nav ul li { margin-right: 10px; }
        nav ul li a { text-decoration: none; color: white; padding: 10px 15px; border-radius: 5px; font-weight: bold; }
        nav ul li a:hover, .active-tab { background-color: #4FB4A8; }
        main { padding-top: 100px; }
    </style>
</head>
<body>
<header>
    <div class="header-flex">
        <form action="/myphpproject/logo_upload.php" method="POST" enctype="multipart/form-data" class="logo-upload">
            <label for="logoInput">
                <img src="<?= htmlspecialchars($logoPath); ?>" alt="Site Logo" id="logoPreview">
            </label>
            <input type="file" name="logo" id="logoInput" accept="image/*" onchange="this.form.submit()">
        </form>

        <h1>TeamO Digital Solutions</h1>
        <nav>
            <ul>
                <li><a href="index.php?page=home">Home</a></li>
                <li><a href="index.php?page=about">About</a></li>
                <li><a href="index.php?page=services">Services</a></li>
                <li><a href="index.php?page=blog">Blog</a></li>
                <li><a href="index.php?page=contact">Contact</a></li>
                <li><a href="index.php?page=gallery">Gallery</a></li>
                <li><a href="index.php?page=login">Login</a></li>
            </ul>
        </nav>
    </div>
</header>



