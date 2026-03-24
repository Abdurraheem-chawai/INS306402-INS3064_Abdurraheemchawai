<?php
require_once __DIR__ . '/../classes/Database.php';

$error = '';
$enrollments = [];
$courses = [];

try {
    $pdo = Database::getConnection();
    
    // --- 1. FILTERING SETUP ---
    $selected_course = $_GET['course_id'] ?? '';
    $where_sql = "";
    $params = [];
    
    if (!empty($selected_course)) {
        $where_sql = "WHERE e.course_id = :course_id";
        $params['course_id'] = $selected_course;
    }

    // --- 2. PAGINATION SETUP ---
    $limit = 5; // Show 5 records per page
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    
    // Count total records to figure out how many pages we need
    $count_stmt = $pdo->prepare("SELECT COUNT(*) FROM enrollments e $where_sql");
    $count_stmt->execute($params);
    $total_records = $count_stmt->fetchColumn();
    $total_pages = ceil($total_records / $limit);
    
    $offset = ($page - 1) * $limit;

    // --- 3. FETCH THE ACTUAL DATA ---
    // The query now dynamically includes our WHERE clause and LIMIT/OFFSET
    $query = "
        SELECT 
            e.id, 
            s.name AS student_name, 
            c.title AS course_title, 
            e.enrolled_at 
        FROM enrollments e
        JOIN students s ON e.student_id = s.id
        JOIN courses c ON e.course_id = c.id
        $where_sql
        ORDER BY e.enrolled_at DESC
        LIMIT :limit OFFSET :offset
    ";
    
    $stmt = $pdo->prepare($query);
    
    // Bind parameters carefully because LIMIT/OFFSET require integers
    if (!empty($selected_course)) {
        $stmt->bindValue(':course_id', $selected_course, PDO::PARAM_INT);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $enrollments = $stmt->fetchAll();

    // Fetch courses for the filter dropdown
    $courses = $pdo->query("SELECT id, title FROM courses ORDER BY title ASC")->fetchAll();

} catch (PDOException $e) {
    error_log('[Enrollments List Error] ' . $e->getMessage());
    $error = 'Could not load enrollments. Please try again.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enrollments — School Enrollment</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; color: #1a1a2e; }
        nav { background: #1a1a2e; padding: 14px 32px; display: flex; gap: 24px; align-items: center; }
        nav a { color: #00d4aa; text-decoration: none; font-weight: 600; }
        nav .brand { color: #fff; font-weight: 700; font-size: 1.1rem; margin-right: auto; }
        .container { max-width: 960px; margin: 40px auto; padding: 0 24px; }
        
        /* New styling for the filter bar and pagination */
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .filter-form { display: flex; gap: 10px; align-items: center; background: #fff; padding: 10px 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        select { padding: 8px; border-radius: 5px; border: 1px solid #ccc; outline: none; }
        .pagination { display: flex; gap: 8px; justify-content: center; margin-top: 20px; }
        .page-link { padding: 8px 12px; background: #fff; border-radius: 6px; text-decoration: none; color: #1a1a2e; font-weight: 600; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .page-link.active { background: #00d4aa; color: #fff; }
        
        h1 { font-size: 1.8rem; margin: 0; }
        .btn { display: inline-block; padding: 8px 18px; border-radius: 6px; font-size: 0.9rem; font-weight: 600; text-decoration: none; border: none; cursor: pointer; }
        .btn-primary { background: #00d4aa; color: #fff; }
        .btn-danger  { background: #e74c3c; color: #fff; }
        .btn-sm { padding: 5px 12px; font-size: 0.8rem; }
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
    <a href="../student/index.php">Students</a>
    <a href="../courses/index.php">Courses</a>
    <a href="index.php">Enrollments</a>
</nav>

<div class="container">
    <div class="header-actions">
        <h1>🔗 Enrollments</h1>
        
        <form method="GET" class="filter-form">
            <label for="course_id" style="font-weight: 600; font-size: 0.9rem;">Filter by Course:</label>
            <select name="course_id" id="course_id" onchange="this.form.submit()">
                <option value="">All Courses</option>
                <?php foreach ($courses as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $selected_course == $c['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <a href="create.php" class="btn btn-primary">+ Process New Enrollment</a>
    </div>

    <?php if (!empty($error)): ?> <div style="color:red; margin-bottom: 20px;"><?= htmlspecialchars($error) ?></div> <?php endif; ?>

    <?php if (empty($enrollments)): ?>
        <div class="empty">No enrollments found for this view.</div>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Course Title</th>
                <th>Date Enrolled</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($enrollments as $e): ?>
            <tr>
                <td><?= $e['id'] ?></td>
                <td><?= htmlspecialchars($e['student_name']) ?></td>
                <td><?= htmlspecialchars($e['course_title']) ?></td>
                <td><?= date('M j, Y', strtotime($e['enrolled_at'])) ?></td>
                <td>
                    <a href="delete.php?id=<?= $e['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Unenroll this student?')">Unenroll</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?><?= !empty($selected_course) ? '&course_id='.$selected_course : '' ?>" 
                   class="page-link <?= ($i === $page) ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

    <?php endif; ?>
</div>
</body>
</html>