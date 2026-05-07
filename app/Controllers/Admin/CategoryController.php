<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Asset;
use App\Core\Database;

class CategoryController extends BaseController
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


    protected function database()
    {
        return Database::getConnection();
    }


    public function index()
    {
        $categoryModel = $this->categoryModel();
        $categories = $categoryModel->allWithCounts();

        $this->render('admin/categories/index', [
            'categories' => $categories
        ]);
    }
    public function create()
    {
        $this->render('admin/categories/create');
    }
    public function store()
    {
        $categoryModel = $this->categoryModel();

        $data = [
            'name' => $_POST['name'],
            'color' => $_POST['color'] ?? 'indigo'
        ];

        $categoryModel->create($data);

        $this->redirect('/admin/categories');
    }

    public function edit($id)
    {
        $category = $this->categoryModel()->find($id);

        if (!$category) {
            $this->redirect('/admin/categories');
        }

        $this->render('admin/categories/edit', [
            'category' => $category
        ]);
    }

    public function update($id)
    {
        $data = [
            'name' => $_POST['name'] ?? '',
            'color' => $_POST['color'] ?? 'indigo'
        ];

        if (empty($data['name'])) {
            $this->redirect('/admin/categories/edit/' . $id);
        }

        $this->categoryModel()->update($id, $data);

        $this->redirect('/admin/categories');
    }

    protected function setArchiveStatus($id, int $status)
    {
        $this->categoryModel()->update($id, [
            'is_archived' => $status
        ]);

        // Call model method instead of raw SQL
        $this->assetModel()->setArchiveByCategory($id, $status);
    }



    public function archive($id)
    {
        $this->setArchiveStatus($id, 1);
        $this->redirect('/admin/categories');
    }

    public function restore($id)
    {
        $this->setArchiveStatus($id, 0);
        $this->redirect('/admin/categories/archive');
    }

    public function apiArchived()
    {
        $categories = $this->categoryModel()->allArchivedWithCounts();

        header('Content-Type: application/json');
        echo json_encode($categories);
        exit;
    }

    public function apiAssets($id)
    {
        $assetModel = $this->assetModel();
        $assets = $assetModel->getByCategory($id);

        header('Content-Type: application/json');
        echo json_encode($assets);
        exit;
    }

    public function show($id)
    {
        $category = $this->categoryModel()->find($id);
        
        if (!$category) {
            $this->redirect('/admin/categories');
        }

        $assets = $this->assetModel()->getByCategory($id);

        $this->render('admin/categories/show', [
            'category' => $category,
            'assets' => $assets
        ]);
    }

    public function archivePage()
    {
        $categories = $this->categoryModel()->allArchivedWithCounts();

        $this->render('admin/categories/archive', [
            'categories' => $categories
        ]);

    }

    public function destroy($id)
    {
        $this->redirect('/admin/categories');
    }
}
