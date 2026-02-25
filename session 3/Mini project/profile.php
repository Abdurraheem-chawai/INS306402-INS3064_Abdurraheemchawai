<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$message = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update bio
    if (isset($_POST['bio'])) {
        $bio = trim($_POST['bio']);
        // Update bio in database
        // $stmt = $pdo->prepare("UPDATE users SET bio = ? WHERE id = ?");
        // $stmt->execute([$bio, $userId]);
        $message = 'Bio updated successfully!';
    }
    
    // Handle avatar upload
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileExt = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (!in_array(strtolower($fileExt), $allowedExts)) {
            $error = 'Invalid file type. Only JPG, PNG, GIF allowed.';
        } elseif ($_FILES['avatar']['size'] > 5000000) { // 5MB limit
            $error = 'File too large. Maximum 5MB allowed.';
        } else {
            $filename = $userId . '_' . time() . '.' . $fileExt;
            $filepath = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $filepath)) {
                // Update avatar in database
                // $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
                // $stmt->execute([$filename, $userId]);
                $message = 'Avatar uploaded successfully!';
            } else {
                $error = 'Failed to upload file.';
            }
        }
    }
}

// Fetch user data (example - uncomment and adapt to your DB)
// $stmt = $pdo->prepare("SELECT name, email, bio, avatar FROM users WHERE id = ?");
// $stmt->execute([$userId]);
// $user = $stmt->fetch();

// Mock data for demonstration
$user = [
    'name' => 'Abdurraheem chawai',
    'email' => 'abdurraheemchawi@gmail.com',
    'bio' => 'Software developer passionate about PHP',
    'avatar' => 'user_avatar.jpg'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; }
        .container { background: #f5f5f5; padding: 20px; border-radius: 8px; }
        h1 { color: #333; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        textarea { resize: vertical; min-height: 100px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .message { color: green; margin-bottom: 15px; }
        .error { color: red; margin-bottom: 15px; }
        .avatar-preview { max-width: 150px; margin-top: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>
        
        <?php if ($message): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Name</label>
                <input type="text" value="<?php echo htmlspecialchars($user['name']); ?>" readonly>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea name="bio" id="bio" placeholder="Tell us about yourself..."><?php echo htmlspecialchars($user['bio']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="avatar">Avatar</label>
                <?php if ($user['avatar']): ?>
                    <img src="uploads/avatars/<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar" class="avatar-preview">
                <?php endif; ?>
                <input type="file" name="avatar" id="avatar" accept="image/*">
                <small>Max 5MB. Allowed: JPG, PNG, GIF</small>
            </div>
            
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>