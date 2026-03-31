<?php
require 'index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST['patient_code'];
    $name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];

    if ($code && $name) {
        $stmt = $pdo->prepare("INSERT INTO patients (patient_code, full_name, gender, phone) VALUES (?, ?, ?, ?)");
        $stmt->execute([$code, $name, $gender, $phone]);

        header("Location: index.php");
    } else {
        echo "Required fields missing!";
    }
}
?>

<h2>Add Patient</h2>

<form method="POST">
    Code: <input type="text" name="patient_code"><br><br>
    Name: <input type="text" name="full_name"><br><br>
    
    Gender:
    <select name="gender">
        <option>Male</option>
        <option>Female</option>
        <option>Other</option>
    </select><br><br>

    Phone: <input type="text" name="phone"><br><br>

    <button type="submit">Save</button>
</form>