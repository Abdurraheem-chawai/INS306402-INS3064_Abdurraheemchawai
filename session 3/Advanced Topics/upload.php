<?php
// Secure Avatar Upload

$uploadDir = __DIR__ . '/uploads/avatars/';
$maxFileSize = 2 * 1024 * 1024; // 2MB
$allowedMimes = ['image/jpeg', 'image/png'];
$allowedExtensions = ['jpg', 'jpeg', 'png'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $file = $_FILES['avatar'];
    
    // Validate file exists
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die('Upload error: ' . $file['error']);
    }
    
    // Validate file size
    if ($file['size'] > $maxFileSize) {
        die('File too large. Maximum size: 2MB');
    }
    
    // Validate MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mimeType, $allowedMimes)) {
        die('Invalid file type. Only JPG and PNG allowed.');
    }
    
    // Validate extension
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExtensions)) {
        die('Invalid file extension.');
    }
    
    // Create uploads directory if needed
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Generate secure filename
    $filename = bin2hex(random_bytes(16)) . '.' . $ext;
    $filepath = $uploadDir . $filename;
    
    // Move file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        echo 'File uploaded successfully: ' . htmlspecialchars($filename);
    } else {
        die('Failed to move uploaded file.');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secure Avatar Upload</title>
</head>
<body>
    <h1>Upload Avatar</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="avatar" accept="image/jpeg,image/png" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>