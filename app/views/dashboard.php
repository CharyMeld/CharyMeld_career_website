<?php include 'app/views/partials/header.php'; ?>
<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and role is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /myphpproject/index.php?page=unauthorized");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }
        .admin-sidebar {
            background-color: #343a40;
            width: 240px;
            height: calc(100vh - 60px);
            position: fixed;
            top: 110px;
            left: 0;
            overflow-y: auto;
            padding-top: 20px;
        }
        .admin-sidebar h4 {
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
        }
        .admin-sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .admin-sidebar ul li a {
            color: #ffffff;
            padding: 14px 20px;
            display: block;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: background-color 0.3s;
        }
        .admin-sidebar ul li a:hover, .admin-sidebar ul li a.active {
            background-color: #007bff;
            color: #ffffff;
        }
        .dashboard-content {
            margin-left: 240px;
            padding: 40px;
        }
        .dashboard-content h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .dashboard-content p {
            color: #666;
        }
        @media screen and (max-width: 768px) {
            .admin-sidebar {
                width: 200px;
                transform: translateX(-100%);
                transition: transform 0.3s;
                z-index: 999;
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .dashboard-content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="admin-sidebar" id="sidebarMenu">
    <h4>Admin Menu</h4>
    <ul>
        <li><a href="index.php?page=admin_reports">📈 View Reports</a></li>
        <li><a href="index.php?page=blog_management">📝 Manage Blogs</a></li>
        <li><a href="index.php?page=user_management">👥 Manage Users</a></li>
        <li><a href="index.php?page=manage_clients">👥 Manage Clients</a></li>
        <li><a href="index.php?page=attendance_report">✅ Attendance Records</a></li>
        <li><a href="index.php?page=attendance">✅ Attendance</a></li>
        <li><a class="text-danger" href="/myphpproject/index.php?page=auth_logout">🔒 Logout</a></li>
    </ul>
</div>
>Logout</a>

<script>
function toggleSidebar() {
    document.getElementById("sidebarMenu").classList.toggle("show");
}
</script>

</body>
</html>
