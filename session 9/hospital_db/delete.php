<?php
require 'index.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM patients WHERE id=?");
$stmt->execute([$id]);

header("Location: index.php");
?>