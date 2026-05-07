<?php
require_once __DIR__ . '/../app/Core/Database.php';
$db = \App\Core\Database::getConnection();

$tables = ['maintenance', 'reports', 'assets'];
$schema = [];
foreach ($tables as $table) {
    try {
        $stmt = $db->query("DESCRIBE $table");
        $schema[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $schema[$table] = "Table not found: " . $e->getMessage();
    }
}

header('Content-Type: application/json');
echo json_encode($schema, JSON_PRETTY_PRINT);
