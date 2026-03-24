<?php
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/ValidationException.php'; // Pull in our new class

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);

        // --- 1. VALIDATION LOGIC ---
        if (empty($title)) {
            throw new ValidationException("Course title is required.");
        }
        
        if (strlen($title) < 3) {
            throw new ValidationException("Course title must be at least 3 characters long.");
        }

        // You can add as many validation rules as you want here!
        // If any of them fail, the code instantly jumps to the 'catch' block below.

        // --- 2. DATABASE LOGIC ---
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO courses (title, description) VALUES (:title, :description)");
        $stmt->execute(['title' => $title, 'description' => $description]);
        
        header("Location: index.php?created=1");
        exit;

    } catch (ValidationException $e) {
        // This catches our specific form validation errors
        $error = $e->getMessage();
    } catch (PDOException $e) {
        // This catches heavy database errors (like server crashes)
        error_log('Insert Course Error: ' . $e->getMessage());
        $error = "A system error occurred. Please try again later.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Course — School Enrollment</title>
    <style>
        /* Paste your exact CSS style block from student/create.php here */
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
        input[type="text"], textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; font-family: inherit; }
    </style>
</head>
<body>
<nav>
    <span class="brand">&lt;/&gt; Enrollment App</span>
    <a href="../student/index.php">Students</a>
    <a href="index.php">Courses</a>
    <a href="../enrollments/index.php">Enrollments</a>
</nav>
<div class="container">
    <h1>+ Add New Course</h1>
    <?php if (!empty($error)): ?> <div class="alert-error"><?= htmlspecialchars($error) ?></div> <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="title">Course Title</label>
            <input type="text" name="title" id="title" required placeholder="e.g. Advanced Database Management">
        </div>
        <div class="form-group">
            <label for="description">Description (Optional)</label>
            <textarea name="description" id="description" rows="4" placeholder="Brief details about the course..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save Course</button>
    </form>
    <a href="index.php" class="btn btn-secondary">Cancel & Go Back</a>
</div>
</body>
</html>