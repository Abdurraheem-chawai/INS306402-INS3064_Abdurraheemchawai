<?php
$host = "localhost";
$dbname = "hospital_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
<?php
$stmt = $pdo->query("SELECT * FROM patients");
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Patients</h2>

<a href="add.php">Add Patient</a>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Code</th>
    <th>Name</th>
    <th>Gender</th>
    <th>Phone</th>
    <th>Actions</th>
</tr>

<?php foreach ($patients as $p): ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= $p['patient_code'] ?></td>
    <td><?= $p['full_name'] ?></td>
    <td><?= $p['gender'] ?></td>
    <td><?= $p['phone'] ?></td>
    <td>
        <a href="edit.php?id=<?= $p['id'] ?>">Edit</a>
        <a href="delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>