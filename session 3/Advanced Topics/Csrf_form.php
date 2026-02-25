<?php
session_start();

// Generate CSRF token if it doesn't exist
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Verify CSRF token
function verifyCSRFToken($token) {
    if (empty($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        http_response_code(403);
        die('CSRF token validation failed');
    }
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    verifyCSRFToken($csrfToken);
    
    // Process form data safely
    echo "Form processed successfully!";
    exit;
}

// Generate token for form
$token = generateCSRFToken();
?>

<!DOCTYPE html>
<html>
<head>
    <title>CSRF Protection - Double Submit Cookie</title>
</head>
<body>
    <h1>CSRF Protected Form</h1>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($token); ?>">
        <input type="text" name="username" placeholder="Enter username" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>