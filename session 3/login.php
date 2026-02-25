<?php
session_start();

// Initialize session variables
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

// Configuration
$MAX_ATTEMPTS = 5;
$LOCKOUT_TIME = 900; // 15 minutes in seconds
$VALID_USERNAME = 'admin';
$VALID_PASSWORD = 'secure_password';

$error_message = '';
$success_message = '';

// Check if user is locked out
$current_time = time();
if ($_SESSION['login_attempts'] >= $MAX_ATTEMPTS) {
    if ($current_time - $_SESSION['last_attempt_time'] < $LOCKOUT_TIME) {
        $remaining_time = $LOCKOUT_TIME - ($current_time - $_SESSION['last_attempt_time']);
        $error_message = "Account locked. Try again in " . ceil($remaining_time / 60) . " minutes.";
    } else {
        // Reset attempts after lockout period
        $_SESSION['login_attempts'] = 0;
    }
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $error_message === '') {
    $username = htmlspecialchars($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validate credentials
    if ($username === $VALID_USERNAME && $password === $VALID_PASSWORD) {
        $_SESSION['authenticated'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['login_attempts'] = 0;
        $success_message = "Login successful!";
        header("Location: dashboard.php");
        exit;
    } else {
        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt_time'] = time();
        $attempts_left = $MAX_ATTEMPTS - $_SESSION['login_attempts'];
        $error_message = "Invalid credentials. Attempts left: " . $attempts_left;
    }
}

// Check if already authenticated
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { font-family: Arial; max-width: 400px; margin: 50px auto; }
        .form-container { border: 1px solid #ddd; padding: 20px; border-radius: 5px; }
        input { width: 100%; padding: 8px; margin: 10px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: #d9534f; margin: 10px 0; }
        .success { color: #5cb85c; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        
        <?php if ($error_message): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <?php if ($success_message): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        
        <p>Attempts: <?php echo $_SESSION['login_attempts'] . "/" . $MAX_ATTEMPTS; ?></p>
    </div>
</body>
</html>