<?php
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/ValidationException.php';

$error = '';
$teacher = null;

if (!isset($_GET['id'])) { header("Location: index.php"); exit; }
$id = $_GET['id'];

try { $pdo = Database::getConnection(); } 
catch (PDOException $e) { die("Database connection failed."); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $expertise = trim($_POST['expertise']);

        if (empty($name) || empty($email) || empty($expertise)) {
            throw new ValidationException("All fields are required.");
        }

        $stmt = $pdo->prepare("UPDATE teachers SET name = :name, email = :email, expertise = :expertise WHERE id = :id");
        $stmt->execute(['name' => $name, 'email' => $email, 'expertise' => $expertise, 'id' => $id]);
        
        header("Location: index.php?updated=1");
        exit;
    } catch (ValidationException $e) {
        $error = $e->getMessage();
    } catch (PDOException $e) {
        $error = ($e->getCode() == 23000) ? "Another teacher is using this email." : "Update failed.";
    }
    $teacher = ['name' => $name, 'email' => $email, 'expertise' => $expertise]; 
} else {
    $stmt = $pdo->prepare("SELECT name, email, expertise FROM teachers WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $teacher = $stmt->fetch();
    if (!$teacher) { header("Location: index.php"); exit; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Teacher</title>
    <style>
        /* Exact same CSS as create.php */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; color: #1a1a2e; }
        nav { background: #1a1a2e; padding: 14px 32px; display: flex; gap: 24px; align-items: center; }
        nav a { color: #00d4aa; text-decoration: none; font-weight: 600; }
        nav .brand { color: #fff; font-weight: 700; font-size: 1.1rem; margin-right: auto; }
        .container { max-width: 600px; margin: 40px auto; padding: 0 24px; }
        h1 { font-size: 1.8rem; margin-bottom: 24px; }
        .btn { display: inline-block; padding: 10px 18px; border-radius: 6px; font-size: 1rem; font-weight: 600; text-decoration: none; border: none; cursor: pointer; }
        .btn-primary { background: #3498db; color: #fff; width: 100%; margin-top: 10px; }
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
    <a href="../student/index.php">Students</a>
    <a href="../courses/index.php">Courses</a>
    <a href="../enrollments/index.php">Enrollments</a>
    <a href="index.php">Teachers</a>
</nav>
<div class="container">
    <h1>✎ Edit Teacher</h1>
    <?php if (!empty($error)): ?> <div class="alert-error"><?= htmlspecialchars($error) ?></div> <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" required value="<?= htmlspecialchars($teacher['name'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required value="<?= htmlspecialchars($teacher['email'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Expertise</label>
            <input type="text" name="expertise" required value="<?= htmlspecialchars($teacher['expertise'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Teacher</button>
    </form>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</div>
</body>
</html>