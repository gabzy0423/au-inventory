<?php

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        // Require the view file
        require_once __DIR__ . '/../Views/home.php';
    }
}
