<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Asset;
use App\Models\Room;
use App\Services\QrService;
use App\Models\Report;

class InventoryController extends BaseController
{
    protected ?Category $categoryModel = null;
    protected ?Asset $assetModel = null;
    protected ?Room $roomModel = null;
    protected ?QrService $qrService = null;
    protected ?Report $reportModel = null;

    protected function categoryModel(): Category
    {
        return $this->categoryModel ??= new Category();
    }

    protected function assetModel(): Asset
    {
        return $this->assetModel ??= new Asset();
    }

    protected function roomModel(): Room
    {
        return $this->roomModel ??= new Room();
    }

    protected function qrService(): QrService
    {
        return $this->qrService ??= new QrService();
    }

    protected function reportModel(): Report
    {
        return $this->reportModel ??= new Report();
    }

    /* =========================
        INVENTORY LIST
    ========================= */
    public function index()
    {
        $this->render('admin/inventory/index', [
            'assets' => $this->assetModel()->allWithCategory(),
            'categories' => $this->categoryModel()->where('is_archived', 0),
            'rooms' => $this->roomModel()->where('is_archived', 0)
        ]);
    }

    /* =========================
        VIEW ASSET
    ========================= */
    public function show($id)
    {
        $item = $this->assetModel()->find($id);

        if (!$item) {
            $this->redirect('/admin/inventory');
        }

        $category = $this->categoryModel()->find($item['category_id'] ?? null);

        $this->render('admin/inventory/show', [
            'item' => $item,
            'category_name' => $category['name'] ?? 'Uncategorized',
            'qr_code_svg' => $this->qrService()->generate($item['tag']),
            'reports' => $this->reportModel()->getPendingByAsset($id),
            'resolved_reports' => $this->reportModel()->getResolvedByAsset($id)
        ]);
    }


    /* =========================
        API DETAIL
    ========================= */
    public function apiDetail($id)
    {
        $item = $this->assetModel()->find($id);

        if (!$item) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Asset not found']);
            exit;
        }

        $category = $this->categoryModel()->find($item['category_id'] ?? null);

        $data = [
            'item' => $item,
            'qr_code_svg' => $this->qrService()->generate($item['tag']),
            'category_name' => $category['name'] ?? 'Uncategorized'
        ];

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /* =========================
        CREATE PAGE
    ========================= */
    public function create()
    {
        $this->render('admin/inventory/create', [
            'categories' => $this->categoryModel()->where('is_archived', 0),
            'rooms' => $this->roomModel()->where('is_archived', 0)
        ]);
    }

    /* =========================
        EDIT PAGE
    ========================= */
    public function edit($id)
    {
        $asset = $this->assetModel()->find($id);

        if (!$asset) {
            $this->redirect('/admin/inventory');
        }

        $this->render('admin/inventory/edit', [
            'asset' => $asset,
            'categories' => $this->categoryModel()->where('is_archived', 0),
            'rooms' => $this->roomModel()->where('is_archived', 0)
        ]);
    }

    /* =========================
        UPDATE LOOKUP
    ========================= */
    public function updateLookup()
    {
        $this->render('admin/inventory/update_lookup', [
            'assets' => $this->assetModel()->allWithCategory(),
            'categories' => $this->categoryModel()->where('is_archived', 0),
            'rooms' => $this->roomModel()->where('is_archived', 0)
        ]);
    }

    /* =========================
        STORE ASSET
    ========================= */
    public function store()
    {
        $tag = 'AU-' . strtoupper(substr(uniqid(), -5));

        $categoryId = $_POST['category_id'] ?: null;
        $location = $_POST['location'];
        $status = $_POST['status'] ?? 'Available';

        if ($status === 'Available') {
            $location = 'Storage';
        } elseif ($location !== 'Storage' && !in_array($status, ['Damaged', 'Under Repair'])) {
            $status = 'In Use';
        }



        $this->assetModel()->create([
            'name' => $_POST['name'],
            'tag' => $tag,
            'asset_number' => $_POST['asset_number'],

            'category_id' => $categoryId,
            'location' => $location,
            'status' => $status,
            'model' => $_POST['model'] ?: null,
            'serial_number' => $_POST['serial_number'] ?: null,
            'description' => $_POST['description'],
            'deployment_date' => $_POST['deployment_date'] ?: null,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $this->redirect('/admin/inventory');
    }

    /* =========================
        UPDATE ASSET
    ========================= */
    public function update($id)
    {
        $categoryId = $_POST['category_id'] ?: null;
        $location = $_POST['location'];
        $status = $_POST['status'];

        if ($status === 'Available') {
            $location = 'Storage';
        } elseif ($location !== 'Storage' && !in_array($status, ['Damaged', 'Under Repair'])) {
            $status = 'In Use';
        }

        $data = [
            'name' => $_POST['name'],
            'asset_number' => $_POST['asset_number'],
            'category_id' => $categoryId,
            'location' => $location,
            'status' => $status,
            'model' => $_POST['model'] ?: null,
            'serial_number' => $_POST['serial_number'] ?: null,
            'description' => $_POST['description'],
            'deployment_date' => $_POST['deployment_date'] ?: null
        ];



        $this->assetModel()->update($id, $data);

        $this->redirect('/admin/inventory#asset-' . $id);
    }

    /* =========================
        ARCHIVE / RESTORE
    ========================= */
    public function archive($id)
    {
        $this->assetModel()->update($id, ['is_archived' => 1]);
        $this->redirect('/admin/inventory');
    }

    public function restore($id)
    {
        $this->assetModel()->update($id, ['is_archived' => 0]);
        $this->redirect('/admin/inventory');
    }

    /* =========================
        ARCHIVE PAGE
    ========================= */
    public function archivePage()
    {
        $this->render('admin/inventory/archive', [
            'archivedAssets' => $this->assetModel()->allArchivedWithCategory(),
            'categories' => $this->categoryModel()->where('is_archived', 0),
            'rooms' => $this->roomModel()->where('is_archived', 0)
        ]);
    }

    /* =========================
        API ARCHIVED
    ========================= */
    public function apiArchived()
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(
            $this->assetModel()->allArchivedWithCategory(),
            JSON_UNESCAPED_UNICODE
        );
        exit;
    }

    /* =========================
        DELETE (placeholder)
    ========================= */
    public function destroy($id)
    {
        $this->redirect('/admin/inventory');
    }
}