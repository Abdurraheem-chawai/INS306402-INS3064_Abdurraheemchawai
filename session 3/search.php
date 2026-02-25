<?php
// Sanitize and retrieve search query from GET parameters
$search_query = isset($_GET['q']) ? htmlspecialchars($_GET['q'], ENT_QUOTES, 'UTF-8') : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
</head>
<body>
    <h1>Search</h1>
    
    <form method="GET" action="search.php">
        <input 
            type="text" 
            name="q" 
            value="<?php echo $search_query; ?>" 
            placeholder="Enter search term"
        >
        <button type="submit">Search</button>
    </form>

    <?php if (!empty($search_query)): ?>
        <h2>Results for: <?php echo $search_query; ?></h2>
        <p>You searched for: <strong><?php echo $search_query; ?></strong></p>
    <?php endif; ?>
</body>
</html>