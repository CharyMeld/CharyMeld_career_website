<?php
$targetDir = "uploads/files/";
if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

$fileName = basename($_FILES["file"]["name"]);
$targetFile = $targetDir . uniqid() . "_" . $fileName;

if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
    echo json_encode(['status' => 'ok', 'url' => $targetFile]);
} else {
    echo json_encode(['status' => 'fail']);
}
?>
