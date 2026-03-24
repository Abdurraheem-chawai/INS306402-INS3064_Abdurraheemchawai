<?php
require_once __DIR__ . '/../classes/Database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if (!empty($name) && !empty($email)) {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("INSERT INTO students (name, email) VALUES (:name, :email)");
            $stmt->execute(['name' => $name, 'email' => $email]);
            
            // Redirect back to index with a success message!
            header("Location: index.php?created=1");
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = "A student with this email already exists.";
            } else {
                error_log('Insert Student Error: ' . $e->getMessage());
                $error = "Could not add student. Please try again.";
            }
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student — School Enrollment</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; color: #1a1a2e; }
        nav { background: #1a1a2e; padding: 14px 32px; display: flex; gap: 24px; align-items: center; }
        nav a { color: #00d4aa; text-decoration: none; font-weight: 600; }
        nav .brand { color: #fff; font-weight: 700; font-size: 1.1rem; margin-right: auto; }
        .container { max-width: 600px; margin: 40px auto; padding: 0 24px; }
        h1 { font-size: 1.8rem; margin-bottom: 24px; }
        .btn { display: inline-block; padding: 10px 18px; border-radius: 6px; font-size: 1rem; font-weight: 600; text-decoration: none; border: none; cursor: pointer; }
        .btn-primary { background: #00d4aa; color: #fff; width: 100%; margin-top: 10px; }
        .btn-secondary { background: #ccc; color: #333; display: block; text-align: center; margin-top: 15px; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; }
        form { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: 600; margin-bottom: 5px; }
        input[type="text"], input[type="email"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; }
    </style>
</head>
<body>

<nav>
    <span class="brand">&lt;/&gt; Enrollment App</span>
    <a href="index.php">Students</a>
    <a href="../courses/index.php">Courses</a>
    <a href="../enrollments/index.php">Enrollments</a>
</nav>

<div class="container">
    <h1>+ Add New Student</h1>

    <?php if (!empty($error)): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" required placeholder="e.g. John Doe">
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" required placeholder="john@example.com">
        </div>
        <button type="submit" class="btn btn-primary">Save Student</button>
    </form>
    
    <a href="index.php" class="btn btn-secondary">Cancel & Go Back</a>
</div>

</body>
</html>