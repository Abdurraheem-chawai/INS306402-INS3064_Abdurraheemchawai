<?php
require_once __DIR__ . '/../classes/Database.php';

if (isset($_GET['id'])) {
    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM teachers WHERE id = :id");
        $stmt->execute(['id' => $_GET['id']]);
        header("Location: index.php?deleted=1");
        exit;
    } catch (PDOException $e) {
        error_log('Delete Teacher Error: ' . $e->getMessage());
        header("Location: index.php?error=Could not delete teacher");
        exit;
    }
}
header("Location: index.php");
exit;