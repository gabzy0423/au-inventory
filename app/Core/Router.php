<?php

namespace App\Core;

class Router {
    protected $routes = [];

    // Register a GET route
    public function get($uri, $action) {
        $this->routes['GET'][$uri] = $action;
    }

    // Register a POST route
    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

    // Dispatch the request
    public function dispatch($uri, $method) {
        $uri = strtok($uri, '?');
        $uri = '/' . trim($uri, '/');

        // RBAC Security Check
        $this->handleSecurity($uri);

        if (!isset($this->routes[$method])) {
            return $this->notFound($uri);
        }

        foreach ($this->routes[$method] as $routePattern => $action) {
            // Convert :param to regex (matches everything except /)
            $regex = preg_replace('/:[a-zA-Z0-9_]+/', '([^/]+)', $routePattern);
            $regex = '#^' . $regex . '$#';

            if (preg_match($regex, $uri, $matches)) {
                array_shift($matches); // Remove the full match

                if (is_string($action) && strpos($action, '@') !== false) {
                    list($controller, $methodName) = explode('@', $action);
                    $controllerClass = "App\\Controllers\\" . $controller;

                    if (class_exists($controllerClass)) {
                        $controllerInstance = new $controllerClass();
                        if (method_exists($controllerInstance, $methodName)) {
                            return call_user_func_array([$controllerInstance, $methodName], $matches);
                        }
                    }
                }

                if (is_callable($action)) {
                    return call_user_func_array($action, $matches);
                }
            }
        }

        return $this->notFound($uri);
    }

    /**
     * Enforce Role-Based Access Control (RBAC)
     */
    protected function handleSecurity($uri) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $base_url = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        $isAdminRoute = strpos($uri, '/admin') === 0;
        $isStaffRoute = strpos($uri, '/staff') === 0;

        if ($isAdminRoute || $isStaffRoute) {
            // 1. Unauthenticated users redirected to login
            if (!isset($_SESSION['user_id'])) {
                header("Location: " . $base_url . "/?error=login_required");
                exit;
            }

            $role = $_SESSION['role'] ?? '';

            // 2. Admin Route Protection
            if ($isAdminRoute && $role !== 'admin') {
                // If staff tries to access admin, send them to their dashboard
                $redirect = ($role === 'staff') ? "/staff/dashboard" : "/";
                header("Location: " . $base_url . $redirect . "?error=unauthorized");
                exit;
            }

            // 3. Staff Route Protection
            if ($isStaffRoute && $role !== 'staff') {
                // If admin tries to access staff, send them to their dashboard
                $redirect = ($role === 'admin') ? "/admin/dashboard" : "/";
                header("Location: " . $base_url . $redirect . "?error=unauthorized");
                exit;
            }
        }
    }

    protected function notFound($uri) {
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        echo "<p>The requested URL {$uri} was not found on this server.</p>";
    }
}
