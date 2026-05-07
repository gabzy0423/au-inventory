<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;

class QrScannerController extends BaseController
{
    public function index() {
        $this->render('staff/qrscanner/index', [], 'staff/layouts/app');
    }

    public function lookup()
    {
        $tag = $_GET['tag'] ?? null;
        if (!$tag) {
            $this->redirect('/staff/qrscanner');
        }

        $assetModel = new \App\Models\Asset();
        // We'll need to find by tag, let's use the generic where method
        $items = $assetModel->where('tag', $tag);
        
        if (count($items) > 0) {
            $item = $items[0];
            $this->redirect('/staff/inventory/show/' . $item['id']);
        }

        // If not found, go back
        $this->redirect('/staff/qrscanner?error=not_found');
    }

    public function scan() {}
}
