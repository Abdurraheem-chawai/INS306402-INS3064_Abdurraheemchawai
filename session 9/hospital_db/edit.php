<?php
require 'index.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM patients WHERE id=?");
$stmt->execute([$id]);
$p = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST['patient_code'];
    $name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];

    $stmt = $pdo->prepare("UPDATE patients SET patient_code=?, full_name=?, gender=?, phone=? WHERE id=?");
    $stmt->execute([$code, $name, $gender, $phone, $id]);

    header("Location: index.php");
}
?>

<h2>Edit Patient</h2>

<form method="POST">
    Code: <input type="text" name="patient_code" value="<?= $p['patient_code'] ?>"><br><br>
    Name: <input type="text" name="full_name" value="<?= $p['full_name'] ?>"><br><br>

    Gender:
    <select name="gender">
        <option <?= $p['gender']=="Male"?"selected":"" ?>>Male</option>
        <option <?= $p['gender']=="Female"?"selected":"" ?>>Female</option>
        <option <?= $p['gender']=="Other"?"selected":"" ?>>Other</option>
    </select><br><br>

    Phone: <input type="text" name="phone" value="<?= $p['phone'] ?>"><br><br>

    <button type="submit">Update</button>
</form>