<?php
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Models/Model.php';
require_once __DIR__ . '/../app/Models/Asset.php';

use App\Models\Asset;

try {
    $assetModel = new Asset();
    $id = $assetModel->create([
        'name' => 'Test Asset',
        'tag' => 'AU-' . strtoupper(substr(uniqid(), -5)),
        'asset_number' => 'TEST-001',
        'image' => null,
        'category_id' => 1,
        'location' => 'Storage',
        'status' => 'Available',
        'description' => 'Test description',
        'created_at' => date('Y-m-d H:i:s')
    ]);
    echo "Success! ID: $id";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
