<?php 
// Ensure only admin can access
if ($_SESSION['role'] !== 'admin') {
    header("Location: /myphpproject/index.php?page=login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission to add a new testimonial
    $client_id = $_POST['client_id'];
    $testimonial_text = $_POST['testimonial_text'];
    $author_name = $_POST['author_name'];

    // Insert testimonial into database
    $stmt = $pdo->prepare("INSERT INTO testimonials (client_id, testimonial_text, author_name) VALUES (?, ?, ?)");
    $stmt->execute([$client_id, $testimonial_text, $author_name]);

    echo "Testimonial added successfully!";
    header("Location: /myphpproject/index.php?page=manage_clients");
    exit();
}

// Fetch all clients for dropdown selection
$stmt = $pdo->query("SELECT * FROM clients");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Testimonial</title>
    <link rel="stylesheet" href="styles.css">
</head>
    <style>
        /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

/* Body and Layout */
body {
    background-color: #f9f9f9;
    color: #333;
    line-height: 1.6;
}

/* Container */
.container {
    width: 80%;
    max-width: 900px;
    margin: 50px auto;
    background-color: #fff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    border-radius: 8px;
}

/* Header */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

header h1 {
    font-size: 2rem;
    color: #333;
}

.back-link a {
    font-size: 1rem;
    color: #007bff;
    text-decoration: none;
    font-weight: 500;
}

.back-link a:hover {
    text-decoration: underline;
}

/* Form Styling */
.form {
    display: flex;
    flex-direction: column;
}

.form-group {
    margin-bottom: 20px;
}

label {
    font-size: 1rem;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"], select, textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
}

textarea {
    resize: vertical;
    min-height: 100px;
}

/* Submit Button */
button[type="submit"] {
    padding: 12px 25px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #218838;
}

/* Styling for Mobile Responsiveness */
@media (max-width: 768px) {
    .container {
        width: 90%;
        padding: 15px;
    }
    header h1 {
        font-size: 1.5rem;
    }
    .form-group input, .form-group select, .form-group textarea {
        font-size: 0.95rem;
    }
}

    </style>
<body> 

    <div class="container">
        <header>
            <h1>Add New Testimonial</h1>
            <div class="back-link">
            <a href="index.php?page=manage_clients">Back to Manage Clients</a>
            </div>
        </header>

        <form action="index.php?page=add_testimonials" method="POST" class="form">
            <div class="form-group">
                <label for="client_id">Select Client:</label>
                <select name="client_id" required>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="testimonial_text">Testimonial Text:</label>
                <textarea name="testimonial_text" required></textarea>
            </div>

            <div class="form-group">
                <label for="author_name">Author Name:</label>
                <input type="text" name="author_name" required>
            </div>

            <button type="submit" class="btn">Add Testimonial</button>
        </form>
    </div>

</body>
</html>
