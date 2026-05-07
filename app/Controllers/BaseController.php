<?php

namespace App\Controllers;

abstract class BaseController
{
    /**
     * Render a view within a layout
     * 
     * @param string $view The view file (e.g., 'admin/dashboard/index')
     * @param array $data Data to pass to the view and layout
     * @param string $layout The layout file (e.g., 'admin/layouts/app')
     */
    protected function render($view, $data = [], $layout = 'admin/layouts/app')
    {
        // Automatically inject base_url for convenience in all views
        $data['base_url'] = $_ENV['BASE_URL'] ?? '/au_inventory/public';

        // Extract data to make variables available in the view and layout
        extract($data);

        // Start output buffering to capture the view content
        ob_start();
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "View not found: " . $view;
        }
        $content = ob_get_clean();

        // Include the layout, which will use the $content variable
        $layoutPath = __DIR__ . '/../Views/' . $layout . '.php';
        if (file_exists($layoutPath)) {
            require_once $layoutPath;
        } else {
            // Fallback if layout not found: just echo content
            echo $content;
        }
    }
    /**
     * Redirect to a specific URL
     * 
     * @param string $url The target URL
     */
    protected function redirect($url)
    {
        $base = $_ENV['BASE_URL'] ?? '/au_inventory/public';
        header("Location: " . $base . $url);
        exit();
    }
}
