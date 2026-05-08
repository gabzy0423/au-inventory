<?php

require_once __DIR__ . '/../vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

// Instantiate the Router
$router = new \App\Core\Router();

// Load the routes file
require_once __DIR__ . '/../routes/web.php';

// Determine current URI and Method
// If you are using standard Apache rewrite rules via `.htaccess` (like we set up),
// `$_GET['url']` might be set, or we can use `REQUEST_URI`. 
// In XAMPP subfolders, $_SERVER['REQUEST_URI'] includes /au_inventory/public/...
// So we use the safe bet: `$_GET['url']` which is populated by `.htaccess`.
$uri = isset($_GET['url']) ? '/' . $_GET['url'] : '/';
$method = $_SERVER['REQUEST_METHOD'];

// Dispatch the request through our router
$router->dispatch($uri, $method);
