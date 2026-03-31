<?php
require 'index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $copies = $_POST['available_copies'];

    if ($isbn && $title && $author && $copies) {
        $stmt = $pdo->prepare("INSERT INTO books (isbn, title, author, available_copies) VALUES (?, ?, ?, ?)");
        $stmt->execute([$isbn, $title, $author, $copies]);

        header("Location: index.php");
    } else {
        echo "All fields are required!";
    }
}
?>

<h2>Add Book</h2>

<form method="POST">
    ISBN: <input type="text" name="isbn"><br><br>
    Title: <input type="text" name="title"><br><br>
    Author: <input type="text" name="author"><br><br>
    Copies: <input type="number" name="available_copies"><br><br>
    
    <button type="submit">Save</button>
</form>