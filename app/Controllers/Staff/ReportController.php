<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\Asset;
use App\Models\Report;
use App\Models\User;
use App\Models\Notification;

class ReportController extends BaseController
{
    /**
     * Show all reports (Incident Log)
     */
    public function index()
    {
        $reportModel = new Report();
        $data = [
            'reports' => $reportModel->getAllByUser($_SESSION['user_id'])
        ];

        $this->render('staff/reports/index', $data, 'staff/layouts/app');
    }

    /**
     * Show Resolved Incident Vault
     */
    public function vault()
    {
        $reportModel = new Report();
        $data = [
            'reports' => $reportModel->getResolvedByUser($_SESSION['user_id'])
        ];

        $this->render('staff/reports/vault', $data, 'staff/layouts/app');
    }

    /**
     * Resolve an incident (Move to Vault)
     */
    public function resolve($id)
    {
        $reportModel = new Report();
        $reportModel->update($id, [
            'status' => 'Resolved',
            'fixed_by' => $_SESSION['user_id'],
            'resolved_at' => date('Y-m-d H:i:s')
        ]);

        
        $this->redirect('/staff/reports');
    }

    /**
     * Show dedicated maintenance queue (Technician View)
     */
    public function maintenance()
    {
        $reportModel = new Report();
        $data = [
            'reports' => $reportModel->getPendingByUser($_SESSION['user_id'])
        ];

        $this->render('staff/maintenance/index', $data, 'staff/layouts/app');
    }


    /**
     * Show form to report an issue for a specific asset
     */
    public function create($id = null)
    {
        $assetModel = new Asset();
        $assets = $assetModel->all(); // Simplified for now, could be filtered

        $item = null;
        if ($id) {
            $item = $assetModel->find($id);
        }

        $data = [
            'item' => $item,
            'assets' => $assets
        ];

        $this->render('staff/reports/create', $data, 'staff/layouts/app');
    }

    /**
     * Store a new damage report
     */
    public function store()
    {
        $assetId = $_POST['asset_id'] ?? null;
        $title = $_POST['title'] ?? 'Issue Reported';
        $description = $_POST['description'] ?? '';

        if (!$assetId) {
            $this->redirect('/staff/inventory');
        }

        $reportModel = new Report();
        $assetModel = new Asset();

        // 1. Create the report record
        $userId = $_SESSION['user_id'] ?? null;
        $isPotential = $_POST['is_potential_duplicate'] ?? 0;
        
        if (!$userId) {
            $this->redirect('/?error=unauthorized');
        }

        $reportId = $reportModel->create([
            'asset_id' => $assetId,
            'user_id' => $userId,
            'title' => $title,
            'description' => $description,
            'status' => 'Pending',
            'is_duplicate' => $isPotential,
            'duplicate_type' => $isPotential ? 'potential' : null
        ]);


        // 2. Update the asset status to 'Damaged'
        $assetModel->update($assetId, ['status' => 'Damaged']);

        // 3. Notify all Admins
        $userModel = new User();
        $admins = $userModel->getAdmins();
        $asset = $assetModel->find($assetId);
        
        foreach ($admins as $admin) {
            Notification::createNotification(
                $admin['id'],
                'New Issue Reported',
                "A new report has been submitted for asset '{$asset['name']}' ({$asset['tag']}) by {$_SESSION['name']}."
            );
        }

        // 3. Redirect back to asset page
        $this->redirect('/staff/inventory/show/' . $assetId);
    }

    /**
     * Mark a repair as completed
     */
    public function fix($id)
    {
        $reportModel = new Report();
        $assetModel = new Asset();

        $report = $reportModel->find($id);
        if (!$report) {
            $this->redirect('/staff/dashboard');
        }

        // 1. Mark report as Fixed
        $reportModel->update($id, [
            'status' => 'Fixed',
            'fixed_by' => $_SESSION['user_id']
        ]);

        // 2. Mark asset as Available
        $assetModel->update($report['asset_id'], ['status' => 'Available']);

        // 3. Notify all Admins
        $userModel = new User();
        $admins = $userModel->getAdmins();
        $asset = $assetModel->find($report['asset_id']);
        
        foreach ($admins as $admin) {
            Notification::createNotification(
                $admin['id'],
                'Maintenance Completed',
                "Asset '{$asset['name']}' (#{$asset['id']}) has been marked as Fixed by {$_SESSION['name']}. Issue: '{$report['title']}'."
            );
        }

        // 4. Redirect back to maintenance queue
        $this->redirect('/staff/maintenance');
    }
    /**
     * API: Check for potential duplicate reports
     */
    public function checkDuplicate()
    {
        $assetId = $_GET['asset_id'] ?? null;
        if (!$assetId) {
            header('Content-Type: application/json');
            echo json_encode([]);
            exit;
        }

        $reportModel = new Report();
        // Check for reports on same asset within last 2 hours that are not Resolved
        $sql = "SELECT r.*, u.name as reported_by 
                FROM reports r 
                LEFT JOIN users u ON r.user_id = u.id
                WHERE r.asset_id = ? 
                AND r.status NOT IN ('Resolved', 'Merged') 
                AND r.reported_at >= DATE_SUB(NOW(), INTERVAL 2 HOUR)
                ORDER BY r.reported_at DESC";
        
        $stmt = $reportModel->getDb()->prepare($sql);
        $stmt->execute([$assetId]);
        $duplicates = $stmt->fetchAll();

        header('Content-Type: application/json');
        echo json_encode($duplicates);
        exit;
    }

    /**
     * Show global incident log for staff visibility (Duplicate prevention)
     */
    public function publicLogs()
    {
        $reportModel = new Report();
        $data = [
            'reports' => $reportModel->getPendingWithAssets() // All active reports
        ];

        $this->render('staff/reports/public', $data, 'staff/layouts/app');
    }
}
