<?php
session_start();

$errors = [];
$success = false;
$formData = [
    'name' => '',
    'email' => '',
    'message' => ''
];

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['name'] = trim($_POST['name'] ?? '');
    $formData['email'] = trim($_POST['email'] ?? '');
    $formData['message'] = trim($_POST['message'] ?? '');
    
    // Validation
    if (empty($formData['name'])) {
        $errors['name'] = 'Name is required.';
    }
    if (empty($formData['email']) || !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Valid email is required.';
    }
    if (empty($formData['message'])) {
        $errors['message'] = 'Message is required.';
    }
    
    // Process if no errors
    if (empty($errors)) {
        // TODO: Process form (save to database, send email, etc.)
        $_SESSION['success_message'] = 'Thank you! Your message has been sent.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Display success message if redirected
if (isset($_SESSION['success_message'])) {
    $success = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .error { color: #d32f2f; font-size: 0.9em; margin-top: 5px; }
        .success { background-color: #4caf50; color: white; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
        button { background-color: #2196f3; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #0b7dda; }
    </style>
</head>
<body>
    <h1>Contact Us</h1>
    
    <?php if ($success): ?>
        <div class="success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($formData['name']); ?>">
            <?php if (isset($errors['name'])): ?>
                <div class="error"><?php echo $errors['name']; ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($formData['email']); ?>">
            <?php if (isset($errors['email'])): ?>
                <div class="error"><?php echo $errors['email']; ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="5"><?php echo htmlspecialchars($formData['message']); ?></textarea>
            <?php if (isset($errors['message'])): ?>
                <div class="error"><?php echo $errors['message']; ?></div>
            <?php endif; ?>
        </div>
        
        <button type="submit">Send Message</button>
    </form>
</body>
</html>