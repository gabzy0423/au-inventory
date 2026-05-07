<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

try {
    $db = Database::getConnection();
    
    // Check if column exists before dropping
    $stmt = $db->query("SHOW COLUMNS FROM assets LIKE 'assigned_user'");
    if ($stmt->fetch()) {
        $db->exec("ALTER TABLE assets DROP COLUMN assigned_user");
        echo "Dropped assigned_user\n";
    } else {
        echo "Column assigned_user does not exist\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
