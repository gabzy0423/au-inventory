<?php
require_once __DIR__ . '/../app/Core/Database.php';
$db = \App\Core\Database::getConnection();
$stmt = $db->prepare("SELECT id FROM assets WHERE id = ?");
$stmt->execute([273]);
$asset = $stmt->fetch();
echo $asset ? "Exists: " . json_encode($asset) : "Not Found";
