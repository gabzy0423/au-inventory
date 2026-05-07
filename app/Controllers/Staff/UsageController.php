<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\Asset;
use App\Models\UsageLog;

class UsageController extends BaseController
{
    /**
     * Show deployment hub
     */
    public function index()
    {
        $usageModel = new UsageLog();
        $data = [
            'active_deployments' => $usageModel->getActiveDeployments(50)
        ];

        $this->render('staff/usage/index', $data, 'staff/layouts/app');
    }

    /**
     * Start a usage/deployment session
     */
    public function start()
    {
        $assetId = $_POST['asset_id'] ?? null;
        $targetLocation = $_POST['target_location'] ?? 'General Lab';
        $purpose = $_POST['purpose'] ?? 'Class Session';

        if (!$assetId) {
            $this->redirect('/staff/inventory');
        }

        $usageModel = new UsageLog();
        $assetModel = new Asset();

        // 1. Create the usage log
        $usageModel->create([
            'asset_id' => $assetId,
            'target_location' => $targetLocation,
            'purpose' => $purpose,
            'started_at' => date('Y-m-d H:i:s')
        ]);

        // 2. Update asset status to 'In Use'
        $assetModel->update($assetId, ['status' => 'In Use']);

        // 3. Redirect back to asset
        $this->redirect('/staff/inventory/show/' . $assetId);
    }

    /**
     * End a usage session (Return asset)
     */
    public function end($id)
    {
        $usageModel = new UsageLog();
        $assetModel = new Asset();

        $session = $usageModel->find($id);
        if (!$session) {
            $this->redirect('/staff/dashboard');
        }

        // 1. Mark session as finished
        $usageModel->update($id, ['finished_at' => date('Y-m-d H:i:s')]);

        // 2. Mark asset as Available
        $assetModel->update($session['asset_id'], ['status' => 'Available']);

        // 3. Redirect back to dashboard
        $this->redirect('/staff/dashboard');
    }
}
