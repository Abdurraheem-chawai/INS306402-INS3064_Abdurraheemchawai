<?php
session_start();

$errors = [];
$success = false;
$formData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = $_POST;
    
    // Validate username
    if (empty($_POST['username'])) {
        $errors['username'] = 'Username is required';
    } elseif (strlen($_POST['username']) < 3) {
        $errors['username'] = 'Username must be at least 3 characters';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
        $errors['username'] = 'Username can only contain letters, numbers, and underscores';
    }
    
    // Validate email
    if (empty($_POST['email'])) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    
    // Validate password
    if (empty($_POST['password'])) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($_POST['password']) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
    } elseif (!preg_match('/[A-Z]/', $_POST['password'])) {
        $errors['password'] = 'Password must contain at least one uppercase letter';
    } elseif (!preg_match('/[0-9]/', $_POST['password'])) {
        $errors['password'] = 'Password must contain at least one number';
    }
    
    // Validate password confirmation
    if (empty($_POST['confirm_password'])) {
        $errors['confirm_password'] = 'Please confirm your password';
    } elseif ($_POST['password'] !== $_POST['confirm_password']) {
        $errors['confirm_password'] = 'Passwords do not match';
    }
    
    // If no errors, simulate storage
    if (empty($errors)) {
        $_SESSION['users'][] = [
            'username' => htmlspecialchars($_POST['username']),
            'email' => htmlspecialchars($_POST['email']),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'registered_at' => date('Y-m-d H:i:s')
        ];
        $success = true;
        $formData = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration System</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 50px auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .error { color: #d32f2f; font-size: 12px; margin-top: 5px; }
        .success { background: #4caf50; color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        button { background: #2196f3; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0b7dda; }
        .users-list { margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>

<h1>Registration System</h1>

<?php if ($success): ?>
    <div class="success">✓ Registration successful! User has been saved.</div>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($formData['username'] ?? '') ?>">
        <?php if (isset($errors['username'])): ?>
            <div class="error"><?= $errors['username'] ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($formData['email'] ?? '') ?>">
        <?php if (isset($errors['email'])): ?>
            <div class="error"><?= $errors['email'] ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <?php if (isset($errors['password'])): ?>
            <div class="error"><?= $errors['password'] ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password">
        <?php if (isset($errors['confirm_password'])): ?>
            <div class="error"><?= $errors['confirm_password'] ?></div>
        <?php endif; ?>
    </div>

    <button type="submit">Register</button>
</form>

<?php if (isset($_SESSION['users']) && !empty($_SESSION['users'])): ?>
    <div class="users-list">
        <h2>Registered Users</h2>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Registered At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['users'] as $user): ?>
                    <tr>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['registered_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

</body>
</html>