<?php
// Initialize variables
$errors = [];
$success = false;
$formData = [
    'name' => '',
    'email' => '',
    'subject' => '',
    'message' => ''
];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and capture input
    $formData['name'] = trim($_POST['name'] ?? '');
    $formData['email'] = trim($_POST['email'] ?? '');
    $formData['subject'] = trim($_POST['subject'] ?? '');
    $formData['message'] = trim($_POST['message'] ?? '');

    // Validation
    if (empty($formData['name'])) {
        $errors[] = 'Name is required.';
    }
    if (empty($formData['email'])) {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email format is invalid.';
    }
    if (empty($formData['subject'])) {
        $errors[] = 'Subject is required.';
    }
    if (empty($formData['message'])) {
        $errors[] = 'Message is required.';
    }

    // Process if no errors
    if (empty($errors)) {
        $success = true;
        // TODO: Send email or save to database
        $formData = ['name' => '', 'email' => '', 'subject' => '', 'message' => ''];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
    <style>
        body { font-family: Arial; max-width: 600px; margin: 50px auto; }
        .error { color: red; margin: 10px 0; }
        .success { color: green; margin: 10px 0; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0 15px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Contact Us</h2>

    <?php if ($success): ?>
        <div class="success">Thank you! Your message has been sent.</div>
    <?php endif; ?>

    <?php if ($errors): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p>- <?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Your Name" value="<?php echo htmlspecialchars($formData['name']); ?>" required>
        <input type="email" name="email" placeholder="Your Email" value="<?php echo htmlspecialchars($formData['email']); ?>" required>
        <input type="text" name="subject" placeholder="Subject" value="<?php echo htmlspecialchars($formData['subject']); ?>" required>
        <textarea name="message" placeholder="Your Message" rows="5" required><?php echo htmlspecialchars($formData['message']); ?></textarea>
        <button type="submit">Send Message</button>
    </form>
</body>
</html>