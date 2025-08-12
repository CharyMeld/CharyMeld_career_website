<?php
session_start();
require_once __DIR__ . "/../../config/database.php";

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?page=login");
    exit();
}

// Fetch all users from the database
$query = "SELECT id, username, email, role FROM users ORDER BY role DESC";
$result = $pdo->query($query);

?>

<?php include __DIR__ . "/header.php"; ?>

<!-- ✅ Admin Dashboard -->
<!-- ✅ Admin Dashboard -->
<div class="admin-dashboard">
    <h2>Admin Dashboard</h2>
    <p>Welcome, <strong><?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?></strong> (Admin)</p>
    <a href="index.php?page=logout" class="btn btn-danger">Logout</a>

    <!-- ✅ Success & Error Messages -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"> <?= htmlspecialchars($_GET['success']); ?> </div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"> <?= htmlspecialchars($_GET['error']); ?> </div>
    <?php endif; ?>

    <!-- ✅ Add New User Button -->
    <div class="user-actions">
        <a href="index.php?page=add_user" class="btn btn-add-user">+ Add New User</a>
    </div>

    <!-- ✅ Manage Users Table -->
    <h3 class="mt-4">Manage Users</h3>
    <div class="table-responsive">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']); ?></td>
                        <td><?= htmlspecialchars($user['username']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td><?= ucfirst(htmlspecialchars($user['role'])); ?></td>
                        <td>
                            <a href="index.php?page=edit_user&id=<?= $user['id']; ?>" class="btn btn-edit">Edit</a>
                            <a href="index.php?page=delete_user&id=<?= $user['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ✅ CSS Styling -->
<style>
    /* ✅ Admin Dashboard Styling */
    .admin-dashboard {
        background-color: #F5F5F5;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 1200px;
        margin: auto;
    }
    .admin-dashboard h2 {
        color: #BDB395;
        text-align: center;
        margin-bottom: 15px;
    }
    .admin-dashboard p {
        text-align: center;
        font-size: 18px;
        color: #444;
    }

    /* ✅ Button Styling */
    .btn {
        display: inline-block;
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 5px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .btn-danger {
        background-color: #d9534f;
        color: #fff;
    }
    .btn-danger:hover {
        background-color: #c9302c;
    }
    .btn-edit {
        background-color: #f0ad4e;
        color: #fff;
    }
    .btn-edit:hover {
        background-color: #ec971f;
    }
    .btn-delete {
        background-color: #d9534f;
        color: #fff;
    }
    .btn-delete:hover {
        background-color: #c9302c;
    }
    .btn-add-user {
        background-color: #BDB395;
        color: #fff;
        padding: 12px 20px;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 5px;
        display: inline-block;
        text-align: center;
        margin: 20px 0;
        transition: all 0.3s ease;
    }
    .btn-add-user:hover {
        background-color: #9E8D6B;
        color: #fff;
    }

    /* ✅ User Actions */
    .user-actions {
        text-align: right;
        margin-bottom: 15px;
    }

    /* ✅ Alerts */
    .alert {
        padding: 12px;
        margin-top: 10px;
        border-radius: 5px;
        text-align: center;
        font-weight: bold;
    }
    .alert-success {
        background-color: #dff0d8;
        color: #3c763d;
    }
    .alert-danger {
        background-color: #f2dede;
        color: #a94442;
    }

    /* ✅ Table Styling */
    .table-responsive {
        overflow-x: auto;
    }
    .styled-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }
    .styled-table th {
        background-color: #BDB395;
        color: #fff;
        padding: 12px;
        text-align: left;
    }
    .styled-table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
    }
    .styled-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .styled-table tr:hover {
        background-color: #f1f1f1;
        transition: 0.3s;
    }
</style>



<?php include __DIR__ . "/footer.php"; ?>
