<style>
body { font-family: Arial; margin: 20px; }
table { border-collapse: collapse; width: 100%; }
th, td { padding: 10px; text-align: left; }
th { background: #333; color: white; }
a { margin-right: 10px; }
</style>
<?php
$host = "localhost";
$dbname = "library2_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
<?php
$stmt = $pdo->query("SELECT * FROM books");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Library2 Books</h2>

<a href="add.php">Add New Book</a>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>ISBN</th>
        <th>Title</th>
        <th>Author</th>
        <th>Copies</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($books as $book): ?>
    <tr>
        <td><?= $book['id'] ?></td>
        <td><?= $book['isbn'] ?></td>
        <td><?= $book['title'] ?></td>
        <td><?= $book['author'] ?></td>
        <td><?= $book['available_copies'] ?></td>
        <td>
            <a href="edit.php?id=<?= $book['id'] ?>">Edit</a>
            <a href="delete.php?id=<?= $book['id'] ?>" onclick="return confirm('Delete this book?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>