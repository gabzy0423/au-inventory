<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Basic Routing logic
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';

// Very simple router matching
if ($url === '') {
    $controller = new \App\Controllers\HomeController();
    $controller->index();
} else {
    // 404 Not Found
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
    echo "<p>The requested URL /" . htmlspecialchars($url) . " was not found on this server.</p>";
}
