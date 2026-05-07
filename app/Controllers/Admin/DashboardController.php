<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Asset;

class DashboardController extends BaseController
{
    protected ?Category $categoryModel = null;
    protected ?Asset $assetModel = null;
    protected function categoryModel(): Category
    {
        if ($this->categoryModel === null) {
            $this->categoryModel = new Category();
        }
        return $this->categoryModel;
    }

    protected function assetModel(): Asset
    {
        if ($this->assetModel === null) {
            $this->assetModel = new Asset();
        }
        return $this->assetModel;
    }

    public function index(): void
    {
        $asset = $this->assetModel();
        $category = $this->categoryModel();

        $data = [
            'stats' => [
                'total_assets' => $asset->countActive(),
                'available' => $asset->countActiveByStatus('Available'),
                'under_repair' => $asset->countActiveByStatus('Under Repair'),
                'damaged' => $asset->countActiveByStatus('Damaged'),
                'approved' => $asset->countActiveByStatus('Approved'),
                'in_use' => $asset->countActiveByStatus('In Use')
            ],
            'recent_assets' => $asset->getRecentWithCategory(20),
            'categories' => $category->allWithCounts(),
            'locations' => $asset->getAssetsByLocation(),
            'recent_activity' => [
                ['type' => 'registration', 'title' => 'New Asset Registered', 'desc' => 'Admin added 5 Dell Monitors to Lab A.', 'time' => '10 mins ago'],
                ['type' => 'qr', 'title' => 'QR Codes Generated', 'desc' => 'Batch QR codes generated for Furniture category.', 'time' => '1 hour ago'],
                ['type' => 'issue', 'title' => 'Issue Reported', 'desc' => 'Staff reported "Broken Screen" on AU-MON-045.', 'time' => '2 hours ago'],
                ['type' => 'maintenance', 'title' => 'Maintenance Completed', 'desc' => 'Technician repaired Yamaha Audio Mixer.', 'time' => 'Yesterday'],
            ]
        ];

        $this->render('admin/dashboard/index', $data);
    }
}
