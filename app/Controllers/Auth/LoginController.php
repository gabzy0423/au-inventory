<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Core\Database;

class LoginController
{
    public function index() {
        $base_url = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        require_once __DIR__ . '/../../Views/auth/login.php';
    }

    public function store() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        $base_url = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);

        if ($user) {
            // Check if user is archived
            if ($user['is_archived'] == 1) {
                header("Location: " . $base_url . "/?error=account_archived");
                exit;
            }

            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['profile_image'] = $user['profile_image'] ?? null;

                if ($user['role'] === 'admin') {
                    header("Location: " . $base_url . "/admin/dashboard");
                } else {
                    header("Location: " . $base_url . "/staff/dashboard");
                }
                exit;
            }
        }

        // Default: invalid credentials
        header("Location: " . $base_url . "/?error=invalid_credentials");
        exit;
    }
}
