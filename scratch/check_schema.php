<?php
require_once __DIR__ . '/../app/Core/Database.php';
$db = \App\Core\Database::getConnection();

$tablesStmt = $db->query("SHOW TABLES");
$tables = $tablesStmt->fetchAll(PDO::FETCH_COLUMN);

$schema = [];
foreach ($tables as $table) {
    $stmt = $db->query("DESCRIBE $table");
    $schema[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

header('Content-Type: application/json');
echo json_encode($schema, JSON_PRETTY_PRINT);

