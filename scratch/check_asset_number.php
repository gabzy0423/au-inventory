<?php
require_once __DIR__ . '/../app/Core/Database.php';
$db = \App\Core\Database::getConnection();
$stmt = $db->query("SHOW COLUMNS FROM assets LIKE 'asset_number'");
$col = $stmt->fetch();
header('Content-Type: application/json');
echo json_encode($col, JSON_PRETTY_PRINT);
