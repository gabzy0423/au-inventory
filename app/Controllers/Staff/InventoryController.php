<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Room;
use App\Models\Report;
use App\Models\UsageLog;
use App\Services\QrService;

class InventoryController extends BaseController
{
    protected ?Asset $assetModel = null;
    protected ?Category $categoryModel = null;
    protected ?Room $roomModel = null;
    protected ?Report $reportModel = null;
    protected ?UsageLog $usageLogModel = null;
    protected ?QrService $qrService = null;

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

    protected function roomModel(): Room
    {
        if ($this->roomModel === null) {
            $this->roomModel = new Room();
        }
        return $this->roomModel;
    }

    protected function reportModel(): Report
    {
        if ($this->reportModel === null) {
            $this->reportModel = new Report();
        }
        return $this->reportModel;
    }

    protected function usageLogModel(): UsageLog
    {
        if ($this->usageLogModel === null) {
            $this->usageLogModel = new UsageLog();
        }
        return $this->usageLogModel;
    }

    protected function qrService(): QrService
    {
        if ($this->qrService === null) {
            $this->qrService = new QrService();
        }
        return $this->qrService;
    }

    public function index()
    {
        $assetModel = $this->assetModel();
        $categoryModel = $this->categoryModel();
        $roomModel = $this->roomModel();

        $assets = $assetModel->allWithCategory();
        $categories = $categoryModel->where('is_archived', 0);
        $rooms = $roomModel->where('is_archived', 0);

        $this->render('staff/inventory/index', [
            'assets' => $assets,
            'categories' => $categories,
            'rooms' => $rooms
        ], 'staff/layouts/app');
    }

    public function apiDetail($id)
    {
        $assetModel = $this->assetModel();
        $qrService = $this->qrService();
        $reportModel = $this->reportModel();
        $usageModel = $this->usageLogModel();

        $item = $assetModel->find($id);

        if (!$item) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Asset not found']);
            exit;
        }

        $data = [
            'item' => $item,
            'qr_code_svg' => $qrService->generate($item['tag']),
            'reports' => $reportModel->getPendingByAsset($id),
            'active_usage' => $usageModel->getActiveByAsset($id)
        ];

        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    public function show($id)
    {
        $assetModel = $this->assetModel();
        $qrService = $this->qrService();
        $reportModel = $this->reportModel();
        $usageModel = $this->usageLogModel();

        $item = $assetModel->findWithCategory($id);

        if (!$item) {
            $this->redirect('/staff/inventory');
        }

        $data = [
            'item' => $item,
            'qr_code_svg' => $qrService->generate($item['tag']),
            'reports' => $reportModel->getPendingByAsset($id),
            'resolved_reports' => $reportModel->getResolvedByAsset($id),
            'category_name' => $item['category_name'] ?? 'General'
        ];


        $this->render('staff/inventory/show', $data, 'staff/layouts/app');
    }
}
