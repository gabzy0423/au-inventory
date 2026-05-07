<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Room;
use App\Models\Asset;
use App\Core\Database;

class RoomController extends BaseController
{
    protected ?Room $roomModel = null;
    protected ?Asset $assetModel = null;
    protected function database()
    {
        return Database::getConnection();
    }

    protected function roomModel(): Room
    {
        if ($this->roomModel === null) {
            $this->roomModel = new Room();
        }
        return $this->roomModel;
    }

    protected function assetModel(): Asset
    {
        if ($this->assetModel === null) {
            $this->assetModel = new Asset();
        }
        return $this->assetModel;
    }

    public function index()
    {
        $roomModel = $this->roomModel();
        $rooms = $roomModel->allWithCounts();

        $this->render('admin/rooms/index', [
            'rooms' => $rooms
        ]);
    }

    public function create()
    {
        $this->render('admin/rooms/create');
    }

    public function archivePage()
    {
        $roomModel = $this->roomModel();
        $rooms = $roomModel->allArchivedWithCounts();

        $this->render('admin/rooms/archive', [
            'rooms' => $rooms
        ]);
    }

    public function store()
    {
        $roomModel = $this->roomModel();

        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'color' => $_POST['color'] ?? 'indigo'
        ];

        $roomModel->create($data);

        $this->redirect('/admin/rooms');
    }

    public function edit($id)
    {
        $roomModel = $this->roomModel();
        $room = $roomModel->find($id);

        if (!$room) {
            $this->redirect('/admin/rooms');
        }

        $this->render('admin/rooms/edit', [
            'room' => $room
        ]);
    }

    public function update($id)
    {
        $roomModel = $this->roomModel();
        $db = $this->database();

        // Get old name to handle asset rename (cascade if name changed)
        $oldRoom = $roomModel->find($id);

        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'color' => $_POST['color']
        ];

        $roomModel->update($id, $data);

        // If name changed, update assets location
        if ($oldRoom && $oldRoom['name'] !== $_POST['name']) {
            $stmt = $db->prepare("UPDATE assets SET location = ? WHERE location = ?");
            $stmt->execute([$_POST['name'], $oldRoom['name']]);
        }

        $this->redirect('/admin/rooms');
    }

    public function archive($id)
    {
        $roomModel = $this->roomModel();
        $db = $this->database();

        $room = $roomModel->find($id);

        $data = ['is_archived' => 1];
        $roomModel->update($id, $data);

        // Cascade archive to assets in this room
        if ($room) {
            $stmt = $db->prepare("UPDATE assets SET is_archived = 1 WHERE location = ?");
            $stmt->execute([$room['name']]);
        }

        $this->redirect('/admin/rooms');
    }

    public function restore($id)
    {
        $roomModel = $this->roomModel();
        $db = $this->database();

        $room = $roomModel->find($id);

        $data = ['is_archived' => 0];
        $roomModel->update($id, $data);

        // Cascade restore to assets in this room
        if ($room) {
            $stmt = $db->prepare("UPDATE assets SET is_archived = 0 WHERE location = ?");
            $stmt->execute([$room['name']]);
        }

        $this->redirect('/admin/rooms');
    }

    public function apiArchived()
    {
        $roomModel = $this->roomModel();
        $rooms = $roomModel->allArchivedWithCounts();

        header('Content-Type: application/json');
        echo json_encode($rooms);
        exit;
    }

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
