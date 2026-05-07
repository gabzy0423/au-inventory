<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Room;


class RoomController extends BaseController
{

    protected ?Asset $assetModel = null;
    protected ?Category $categoryModel = null;
    protected ?Room $roomModel = null;

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
    /**
     * Show internal room overview for staff
     */
    public function index()
    {
        $roomModel = $this->roomModel();
        $rooms = $roomModel->allWithCounts();

        $this->render('staff/rooms/index', [
            'rooms' => $rooms
        ], 'staff/layouts/app');
    }

    /**
     * API endpoint to browse assets in a specific room
     */
    public function apiAssets($id)
    {
        $roomModel = $this->roomModel();
        $assetModel = $this->assetModel();

        $room = $roomModel->find($id);
        $assets = $room ? $assetModel->getByLocation($room['name']) : [];

        header('Content-Type: application/json');
        echo json_encode($assets);
        exit;
    }
}
