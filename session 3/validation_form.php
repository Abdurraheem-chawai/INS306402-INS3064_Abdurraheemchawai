<?php
$errors = [];
$formData = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['name'] = trim($_POST['name'] ?? '');
    $formData['email'] = trim($_POST['email'] ?? '');
    $formData['phone'] = trim($_POST['phone'] ?? '');
    $formData['message'] = trim($_POST['message'] ?? '');

    // Validation
    if (empty($formData['name'])) {
        $errors['name'] = 'Name is required';
    }
    if (empty($formData['email']) || !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Valid email is required';
    }
    if (empty($formData['phone']) || !preg_match('/^\d{10}$/', str_replace('-', '', $formData['phone']))) {
        $errors['phone'] = 'Valid 10-digit phone number is required';
    }
    if (empty($formData['message']) || strlen($formData['message']) < 10) {
        $errors['message'] = 'Message must be at least 10 characters';
    }

    // If no errors, process form
    if (empty($errors)) {
        // Process form submission
        echo '<div class="success">Form submitted successfully!</div>';
        $formData = ['name' => '', 'email' => '', 'phone' => '', 'message' => ''];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sticky Form</title>
    <style>
        .error { color: red; font-size: 0.9em; margin-top: 5px; }
        .form-group { margin-bottom: 15px; }
        input, textarea { padding: 8px; width: 100%; box-sizing: border-box; }
        .success { color: green; padding: 10px; background: #f0f0f0; }
    </style>
</head>
<body>
    <form method="POST">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($formData['name']) ?>">
            <?php if (isset($errors['name'])): ?>
                <div class="error"><?= $errors['name'] ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($formData['email']) ?>">
            <?php if (isset($errors['email'])): ?>
                <div class="error"><?= $errors['email'] ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($formData['phone']) ?>">
            <?php if (isset($errors['phone'])): ?>
                <div class="error"><?= $errors['phone'] ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Message:</label>
            <textarea name="message"><?= htmlspecialchars($formData['message']) ?></textarea>
            <?php if (isset($errors['message'])): ?>
                <div class="error"><?= $errors['message'] ?></div>
            <?php endif; ?>
        </div>

        <button type="submit">Submit</button>
    </form>
</body>
</html>