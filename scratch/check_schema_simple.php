<?php
require_once __DIR__ . '/../app/Core/Database.php';
$db = \App\Core\Database::getConnection();
$stmt = $db->query("DESCRIBE assets");
$cols = $stmt->fetchAll(PDO::FETCH_COLUMN);
echo implode(", ", $cols);
