<?php
require_once __DIR__ . '/../classes/Database.php';

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query("SELECT * FROM students ORDER BY created_at DESC");
    $students = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log('[Students List Error] ' . $e->getMessage());
    $error = 'Could not load students. Please try again.';
    $students = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students — School Enrollment</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; color: #1a1a2e; }
        nav { background: #1a1a2e; padding: 14px 32px; display: flex; gap: 24px; align-items: center; }
        nav a { color: #00d4aa; text-decoration: none; font-weight: 600; }
        nav .brand { color: #fff; font-weight: 700; font-size: 1.1rem; margin-right: auto; }
        .container { max-width: 960px; margin: 40px auto; padding: 0 24px; }
        h1 { font-size: 1.8rem; margin-bottom: 24px; display: flex; align-items: center; }
        .btn { display: inline-block; padding: 8px 18px; border-radius: 6px; font-size: 0.9rem; font-weight: 600; text-decoration: none; border: none; cursor: pointer; }
        .btn-primary { background: #00d4aa; color: #fff; }
        .btn-danger  { background: #e74c3c; color: #fff; }
        .btn-sm { padding: 5px 12px; font-size: 0.8rem; }
        .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error   { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.07); }
        th { background: #1a1a2e; color: #fff; padding: 12px 16px; text-align: left; font-size: 0.85rem; }
        td { padding: 12px 16px; border-top: 1px solid #f0f2f5; }
        tr:hover td { background: #f8f9fa; }
        .empty { text-align: center; padding: 48px; color: #888; background: #fff; border-radius: 10px; }
    </style>
</head>
<body>
<nav>
    <span class="brand">&lt;/&gt; Enrollment App</span>
    <a href="../students/index.php">Students</a>
    <a href="../courses/index.php">Courses</a>
    <a href="../enrollments/index.php">Enrollments</a>
</nav>
<div class="container">
    <h1>👥 Students
        <a href="create.php" class="btn btn-primary" style="margin-left:auto;">+ Add Student</a>
    </h1>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">✅ Student deleted successfully.</div>
    <?php elseif (isset($_GET['created'])): ?>
        <div class="alert alert-success">✅ Student created successfully.</div>
    <?php elseif (isset($_GET['updated'])): ?>
        <div class="alert alert-success">✅ Student updated successfully.</div>
    <?php endif; ?>

    <?php if (empty($students)): ?>
        <div class="empty">No students yet. <a href="create.php">Add one!</a></div>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $s): ?>
            <tr>
                <td><?= $s['id'] ?></td>
                <td><?= htmlspecialchars($s['name']) ?></td>
                <td><?= htmlspecialchars($s['email']) ?></td>
                <td><?= date('M j, Y', strtotime($s['created_at'])) ?></td>
                <td>
                    <a href="edit.php?id=<?= $s['id'] ?>"
                       class="btn btn-sm"
                       style="background:#3498db;color:#fff;margin-right:6px;">Edit</a>
                    <a href="delete.php?id=<?= $s['id'] ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Delete <?= htmlspecialchars(addslashes($s['name'])) ?>?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
</body>
</html>