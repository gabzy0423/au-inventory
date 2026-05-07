<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Asset;
use App\Models\Report;
use App\Models\Notification;

class ReportController extends BaseController
{
    /**
     * Show all reports (Incident Log) for Admin
     */
    public function index()
    {
        $reportModel = new Report();
        $data = [
            'reports' => $reportModel->getAllWithAssets()
        ];

        $this->render('admin/reports/index', $data);
    }

    /**
     * Show detailed view of a single report
     */
    public function show($id)
    {
        $reportModel = new Report();
        $assetModel = new Asset();
        
        $report = $reportModel->find($id);
        if (!$report) {
            $this->redirect('/admin/reports');
        }

        // Get asset details
        $asset = $assetModel->find($report['asset_id']);
        
        // Get reporter details
        $userModel = new \App\Models\User();
        $reporter = $userModel->find($report['user_id']);

        $data = [
            'report' => $report,
            'asset' => $asset,
            'reporter' => $reporter
        ];

        $this->render('admin/reports/show', $data);
    }

    /**
     * Show resolved reports history
     */
    public function resolved()
    {
        $reportModel = new Report();
        $data = [
            'reports' => $reportModel->getResolvedWithAssets()
        ];

        $this->render('admin/reports/resolved', $data);
    }

    /**
     * Show report vault (Status: Fixed)
     */
    public function vault()
    {
        $reportModel = new Report();
        $data = [
            'reports' => $reportModel->getVaultReports()
        ];

        $this->render('admin/reports/vault', $data);
    }

    /**
     * Show maintenance queue for Admin oversight
     */
    public function maintenance()
    {
        $reportModel = new Report();
        $data = [
            'reports' => $reportModel->getAllActiveWithAssets()
        ];

        $this->render('admin/maintenance/index', $data);
    }

    /**
     * Approve a reported issue
     */
    public function approve($id)
    {
        $reportModel = new Report();
        $assetModel = new Asset();

        $report = $reportModel->find($id);
        if ($report) {
            // 1. Mark report as Approved (Request Status)
            $reportModel->update($id, ['status' => 'Approved']);
            
            // 2. Create Notification for the reporter
            if ($report['user_id']) {
                $asset = $assetModel->find($report['asset_id']);
                Notification::createNotification(
                    $report['user_id'],
                    'Report Approved',
                    "Your report for asset '{$asset['name']}' has been approved and is now in the maintenance queue."
                );
            }
        }

        $this->redirect('/admin/maintenance');
    }

    /**
     * Start repair on an approved issue
     */
    public function start($id)
    {
        $reportModel = new Report();
        $assetModel = new Asset();

        $report = $reportModel->find($id);
        if ($report) {
            // 1. Mark report as Under Repair (Maintenance Status)
            $reportModel->update($id, ['status' => 'Under Repair']);
            
            // 2. Mark asset as Under Repair (Asset Condition)
            $assetModel->update($report['asset_id'], ['status' => 'Under Repair']);

            // 3. Create Notification for the reporter
            if ($report['user_id']) {
                $asset = $assetModel->find($report['asset_id']);
                Notification::createNotification(
                    $report['user_id'],
                    'Repair Started',
                    "Maintenance has started on asset '{$asset['name']}'. Status updated to Under Repair."
                );
            }
        }

        $this->redirect('/admin/maintenance');
    }

    /**
     * Mark a repair as completed (Admin Oversight)
     */
    public function fix($id)
    {
        $reportModel = new Report();
        $assetModel = new Asset();

        $report = $reportModel->find($id);
        if (!$report) {
            $this->redirect('/admin/maintenance');
        }

        // 1. Mark report as Fixed (Request Status)
        $reportModel->update($id, [
            'status' => 'Fixed',
            'fixed_by' => $_SESSION['user_id']
        ]);

        // 2. Mark asset as Available (Asset Condition)
        $assetModel->update($report['asset_id'], ['status' => 'Available']);

        // 3. Create Notification for the reporter
        if ($report['user_id']) {
            $asset = $assetModel->find($report['asset_id']);
            Notification::createNotification(
                $report['user_id'],
                'Asset Fixed',
                "The issue with asset '{$asset['name']}' has been resolved. The asset is now back to Available status."
            );
        }

        // 3. Handle response based on request type
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;
        }

        $this->redirect('/admin/maintenance');
    }

    /**
     * Resolve a report (Move to history)
     */
    public function resolve($id)
    {
        $reportModel = new Report();
        $report = $reportModel->find($id);

        if ($report && $report['status'] === 'Fixed') {
            $reportModel->update($id, [
                'status' => 'Resolved',
                'fixed_by' => $_SESSION['user_id'],
                'resolved_at' => date('Y-m-d H:i:s')
            ]);
        }


        $this->redirect('/admin/reports');
    }

    /**
     * Export resolved reports to CSV (Excel compatible)
     */
    public function export()
    {
        $reportModel = new Report();
        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;

        $reports = $reportModel->getResolvedFiltered($startDate, $endDate);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=resolved_reports_' . date('Y-m-d') . '.csv');

        $output = fopen('php://output', 'w');
        
        // CSV Headers
        fputcsv($output, ['Report ID', 'Asset Name', 'Asset Tag', 'Incident Title', 'Description', 'Reported By', 'Date Reported']);

        // Data Rows
        foreach ($reports as $report) {
            fputcsv($output, [
                $report['id'],
                $report['asset_name'],
                $report['asset_tag'],
                $report['title'],
                $report['description'],
                $report['reported_by_name'] ?? 'System',
                date('M d, Y H:i', strtotime($report['reported_at']))
            ]);
        }

        fclose($output);
        exit;
    }

    /**
     * Show form to report an issue for a specific asset (Admin)
     */
    public function create($id)
    {
        $assetModel = new Asset();
        $item = $assetModel->find($id);

        if (!$item) {
            $this->redirect('/admin/inventory');
        }

        $data = [
            'item' => $item
        ];

        $this->render('admin/reports/create', $data);
    }

    /**
     * Store a new damage report (Admin)
     */
    public function store()
    {
        $assetId = $_POST['asset_id'] ?? null;
        $title = $_POST['title'] ?? 'Issue Reported';
        $description = $_POST['description'] ?? '';

        if (!$assetId) {
            $this->redirect('/admin/inventory');
        }

        $reportModel = new Report();
        $assetModel = new Asset();

        // 1. Create the report record
        $userId = $_SESSION['user_id'] ?? null;
        
        if (!$userId) {
            $this->redirect('/?error=unauthorized');
        }

        $reportModel->create([
            'asset_id' => $assetId,
            'user_id' => $userId,
            'title' => $title,
            'description' => $description,
            'status' => 'Pending'
        ]);


        // 2. Update the asset status to 'Damaged'
        $assetModel->update($assetId, ['status' => 'Damaged']);

        // 3. Redirect back to asset page
        $this->redirect('/admin/inventory/show/' . $assetId);
    }

    /**
     * Merge multiple reports into a single primary record
     */
    public function merge()
    {
        $reportIds = $_POST['report_ids'] ?? [];
        $primaryId = $_POST['primary_report_id'] ?? null;

        if (count($reportIds) < 2 || !$primaryId) {
            $this->redirect('/admin/maintenance');
        }

        $reportModel = new Report();
        
        // 1. Validate that all reports exist
        foreach ($reportIds as $id) {
            if ($id != $primaryId) {
                $reportModel->update($id, [
                    'status' => 'Resolved',
                    'is_duplicate' => 1,
                    'duplicate_type' => 'duplicate',
                    'merged_into_id' => $primaryId
                ]);
            }
        }

        // 2. Optional: Add a comment to the primary report or update its description
        $primary = $reportModel->find($primaryId);
        $mergeCount = count($reportIds) - 1;
        $reportModel->update($primaryId, [
            'description' => $primary['description'] . "\n\n[System Note: {$mergeCount} reports merged into this record for consolidated tracking.]"
        ]);

        $this->redirect('/admin/maintenance');
    }
}
