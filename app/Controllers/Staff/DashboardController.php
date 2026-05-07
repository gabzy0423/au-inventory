<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\Asset;  
use App\Models\Category;
use App\Models\Report;


class DashboardController extends BaseController
{
    protected ?Asset $assetModel = null;
    protected ?Category $categoryModel = null;
    protected ?Report $reportModel = null;      

    protected function assetModel(): Asset
    {
        if ($this->assetModel === null) {
            $this->assetModel = new Asset();
        }
        return $this->assetModel;
    }   

    protected function categoryModel(): Category
    {
        if ($this->categoryModel === null) {
            $this->categoryModel = new Category();
        }
        return $this->categoryModel;
    }

    protected function reportModel(): Report
    {
        if ($this->reportModel === null) {
            $this->reportModel = new Report();
        }
        return $this->reportModel;
    }
    public function index() {
        $assetModel = $this->assetModel();
        $categoryModel = $this->categoryModel();
        $reportModel = $this->reportModel();

        $data = [
            'stats' => [
                'total_assets' => $assetModel->countActive(),
                'available' => $assetModel->countActiveByStatus('Available'),
                'damaged' => $assetModel->countActiveByStatus('Damaged'),
                'approved' => $assetModel->countActiveByStatus('Approved'),
                'under_repair' => $assetModel->countActiveByStatus('Under Repair'),
                'in_use' => $assetModel->countActiveByStatus('In Use')
            ],
            'categories' => $categoryModel->allWithCounts(),
            'locations' => $assetModel->getAssetsByLocation(),
            'recent_activity' => [
                ['type' => 'scan', 'title' => 'Asset Tag Scanned', 'desc' => 'AU-LAP-001 check-in complete.', 'time' => '2 mins ago'],
                ['type' => 'report', 'title' => 'Issue Logged', 'desc' => 'Reported "Broken Screen" on AU-MON-045.', 'time' => '1 hour ago'],
                ['type' => 'maintenance', 'title' => 'Repair Verified', 'desc' => 'Yamaha Mixer status set to Available.', 'time' => '3 hours ago'],
            ],
            'maintenance_tasks' => $reportModel->getPendingByUser($_SESSION['user_id'])
        ];
        $this->render('staff/dashboard/index', $data, 'staff/layouts/app');
    }
}
