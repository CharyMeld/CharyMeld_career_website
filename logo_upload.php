<?php
session_start();

$targetDir = "public/uploads/";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['logo'])) {
    if ($_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $logoFileName = time() . "_" . basename($_FILES["logo"]["name"]);
        $targetFile = $targetDir . $logoFileName;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $targetFile)) {
            // Store the relative path in session
            $_SESSION['logo'] = "/myphpproject/" . $targetFile;
        }
    }
}

// Redirect back to the home page (or wherever you prefer)
header("Location: index.php?page=home");
exit();
