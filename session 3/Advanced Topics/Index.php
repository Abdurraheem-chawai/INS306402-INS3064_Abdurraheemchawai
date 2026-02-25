<?php
// Simple Front Controller Router

// Get the page parameter from query string, default to 'home'
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Sanitize the page parameter to prevent directory traversal
$page = preg_replace('/[^a-z0-9_-]/', '', strtolower($page));

// Define available routes and their corresponding view files
$routes = [
    'home' => 'views/home.php',
    'about' => 'views/about.php',
    'contact' => 'views/contact.php',
];

// Check if the requested page exists in routes
if (array_key_exists($page, $routes)) {
    $viewFile = $routes[$page];
    
    // Verify the view file exists before including it
    if (file_exists($viewFile)) {
        include $viewFile;
    } else {
        http_response_code(500);
        echo "<h1>500 - Server Error</h1>";
        echo "<p>View file not found.</p>";
    }
} else {
    // Route not found - show 404 page
    http_response_code(404);
    include 'views/404.php';
}
?>