<?php
session_start();

$password = '';
$feedback = [];
$isValid = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    
    // Check for uppercase
    if (!preg_match('/[A-Z]/', $password)) {
        $feedback[] = 'Missing uppercase letter (A-Z)';
    }
    
    // Check for lowercase
    if (!preg_match('/[a-z]/', $password)) {
        $feedback[] = 'Missing lowercase letter (a-z)';
    }
    
    // Check for number
    if (!preg_match('/[0-9]/', $password)) {
        $feedback[] = 'Missing number (0-9)';
    }
    
    // Check for symbol
    if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password)) {
        $feedback[] = 'Missing symbol (!@#$%^&*...)';
    }
    
    // Check minimum length
    if (strlen($password) < 8) {
        $feedback[] = 'Password must be at least 8 characters';
    }
    
    $isValid = empty($feedback);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Validation</title>
    <style>
        body { font-family: Arial; max-width: 400px; margin: 50px auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: #dc3545; margin-top: 10px; }
        .success { color: #28a745; font-weight: bold; }
        ul { margin: 10px 0; padding-left: 20px; }
    </style>
</head>
<body>
    <h1>Complex Password Validator</h1>
    
    <form method="POST">
        <div class="form-group">
            <label for="password">Enter Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Validate</button>
    </form>
    
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <?php if ($isValid): ?>
            <p class="success">✓ Password is valid!</p>
        <?php else: ?>
            <div class="error">
                <p>Password requirements not met:</p>
                <ul>
                    <?php foreach ($feedback as $message): ?>
                        <li><?php echo htmlspecialchars($message); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>