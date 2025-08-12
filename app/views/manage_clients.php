<?php
// Ensure only admin can access
if ($_SESSION['role'] !== 'admin') {
    header("Location: /myphpproject/index.php?page=login");
    exit();
}

// Fetch clients from database
$stmt = $pdo->query("SELECT * FROM clients");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Clients</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #f4f7fc;
    color: #333;
    line-height: 1.6;
}

/* Container and Layout */
.container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 20px;
    border-bottom: 2px solid #eee;
    margin-bottom: 30px;
}

header h1 {
    font-size: 2.5rem;
    color: #2e3a59;
}

.dashboard-link a {
    text-decoration: none;
    color: #007bff;
    font-size: 1.1rem;
    font-weight: 500;
}

/* Actions Buttons */
.actions {
    margin-bottom: 20px;
}

.actions .btn {
    display: inline-block;
    padding: 10px 20px;
    margin-right: 10px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.actions .btn:hover {
    background-color: #0056b3;
}

/* Table Styling */
.clients-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.clients-table th,
.clients-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.clients-table th {
    background-color: #007bff;
    color: white;
}

.clients-table td {
    background-color: #f9f9f9;
}

.clients-table tr:hover td {
    background-color: #f1f1f1;
}

/* Action Buttons in Table */
.edit-btn, .delete-btn {
    text-decoration: none;
    padding: 6px 10px;
    border-radius: 3px;
    color: white;
}

.edit-btn {
    background-color: #28a745;
}

.delete-btn {
    background-color: #dc3545;
}

.edit-btn:hover {
    background-color: #218838;
}

.delete-btn:hover {
    background-color: #c82333;
}

</style>
<body>

    <div class="container">
        <header>
            <h1>Manage Clients</h1>
            <div class="dashboard-link">
                <a href="index.php?page=dashboard">Back to Dashboard</a>
            </div>
        </header>

        <div class="actions">
            <a href="index.php?page=add_clients" class="btn">Add New Client</a>
            <a href="index.php?page=add_testimonials" class="btn">Add Testimonial</a>
        </div>

        <h2>Clients List</h2>
        <table class="clients-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Logo</th>
                    <th>Website</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= htmlspecialchars($client['name']) ?></td>
                    <td><?= htmlspecialchars($client['description']) ?></td>
                    <td><img src="uploads/<?= htmlspecialchars($client['logo']) ?>" alt="<?= htmlspecialchars($client['name']) ?>" width="100"></td>
                    <td><a href="<?= htmlspecialchars($client['website']) ?>" target="_blank">Visit</a></td>
                    <td>
                        <a href="edit_client.php?id=<?= $client['id'] ?>" class="edit-btn">Edit</a> | 
                        <a href="delete_client.php?id=<?= $client['id'] ?>" class="delete-btn">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
