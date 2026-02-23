<?php
$students = [
    ['name' => 'Alice', 'grade' => 90],
    ['name' => 'Bob', 'grade' => 85],
    ['name' => 'Charlie', 'grade' => 92],
    ['name' => 'Diana', 'grade' => 88],
    ['name' => 'Eve', 'grade' => 95]
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <style>
        table { border-collapse: collapse; width: 400px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
    </style>
</head>
<body>
    <h1>Student List</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['name']); ?></td>
                    <td><?php echo htmlspecialchars($student['grade']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>