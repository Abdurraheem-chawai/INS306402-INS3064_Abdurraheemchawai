<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        nav {
            background: #333;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav h1 {
            font-size: 1.5rem;
        }
        nav a {
            color: white;
            text-decoration: none;
            background: #e74c3c;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background 0.3s;
        }
        nav a:hover {
            background: #c0392b;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .welcome {
            font-size: 2rem;
            color: #333;
            margin-bottom: 1rem;
        }
        .info {
            color: #666;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <nav>
        <h1>Dashboard</h1>
        <a href="?action=logout">Logout</a>
    </nav>

    <div class="container">
        <h2 class="welcome">Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        <div class="info">
            <p>You are successfully logged in to your dashboard.</p>
            <p><strong>Session ID:</strong> <?php echo session_id(); ?></p>
        </div>
    </div>
</body>
</html>