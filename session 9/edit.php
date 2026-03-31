<?php
require 'index.php';

// Get book ID
$id = $_GET['id'];

// Fetch existing data
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

// Update when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $copies = $_POST['available_copies'];

    if ($isbn && $title && $author && $copies) {
        $stmt = $pdo->prepare("UPDATE books SET isbn=?, title=?, author=?, available_copies=? WHERE id=?");
        $stmt->execute([$isbn, $title, $author, $copies, $id]);

        header("Location: index.php");
    } else {
        echo "All fields are required!";
    }
}
?>

<h2>Edit Book</h2>

<form method="POST">
    ISBN: <input type="text" name="isbn" value="<?= $book['isbn'] ?>"><br><br>
    Title: <input type="text" name="title" value="<?= $book['title'] ?>"><br><br>
    Author: <input type="text" name="author" value="<?= $book['author'] ?>"><br><br>
    Copies: <input type="number" name="available_copies" value="<?= $book['available_copies'] ?>"><br><br>

    <button type="submit">Update</button>
</form>