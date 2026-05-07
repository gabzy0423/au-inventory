<?php
require_once __DIR__ . '/../app/Core/Database.php';
$db = \App\Core\Database::getConnection();
$stmt = $db->query("SHOW INDEX FROM assets WHERE Column_name = 'asset_number'");
$index = $stmt->fetch();
echo $index ? "Index: " . json_encode($index) : "No unique index on asset_number";
