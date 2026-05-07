<?php
require_once __DIR__ . '/../app/Core/Database.php';
$db = \App\Core\Database::getConnection();

try {
    $db->exec("ALTER TABLE reports ADD COLUMN resolution_details TEXT NULL AFTER description");
    echo "Added resolution_details column.\n";
} catch (Exception $e) {
    echo "resolution_details column might already exist: " . $e->getMessage() . "\n";
}

try {
    $db->exec("ALTER TABLE reports ADD COLUMN resolved_at TIMESTAMP NULL AFTER reported_at");
    echo "Added resolved_at column.\n";
} catch (Exception $e) {
    echo "resolved_at column might already exist: " . $e->getMessage() . "\n";
}
