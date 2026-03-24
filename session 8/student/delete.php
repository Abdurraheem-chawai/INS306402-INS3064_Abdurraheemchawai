<?php
require_once __DIR__ . '/../classes/Database.php';

if (isset($_GET['id'])) {
    try {
        $pdo = Database::getConnection();
        
        // Prepare and execute the delete statement
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
        $stmt->execute(['id' => $_GET['id']]);
        
        // Redirect back to the list with a success flag
        header("Location: index.php?deleted=1");
        exit;
        
    } catch (PDOException $e) {
        error_log('Delete Student Error: ' . $e->getMessage());
        // Redirect back with an error flag if something goes wrong
        header("Location: index.php?error=Could not delete student");
        exit;
    }
} else {
    // If someone visits this page without an ID, just send them back
    header("Location: index.php");
    exit;
}