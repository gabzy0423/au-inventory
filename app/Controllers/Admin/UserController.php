<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\User;

class UserController extends BaseController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $currentUserId = $_SESSION['user_id'] ?? 0;
        $userModel = new User();

        // Fetch non-archived users, excluding the currently logged-in account
        $users = $userModel->allExcept($currentUserId);

        $this->render('admin/users/index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $this->render('admin/users/create');
    }

    public function edit($id)
    {
        $userModel = new User();
        $user = $userModel->find($id);
        
        if (!$user) {
            $this->redirect('/admin/users');
        }

        $this->render('admin/users/edit', [
            'user' => $user
        ]);
    }

    public function show($id)
    {
        $userModel = new User();
        $user = $userModel->find($id);
        
        if (!$user) {
            $this->redirect('/admin/users');
        }

        $this->render('admin/users/show', [
            'user' => $user
        ]);
    }

    public function archivePage()
    {
        $userModel = new User();
        $archivedUsers = $userModel->where('is_archived', 1);

        $this->render('admin/users/archive', [
            'archivedUsers' => $archivedUsers
        ]);
    }

    public function store()
    {
        $userModel = new User();
        
        $data = [
            'name'     => $_POST['name'],
            'email'    => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role'     => strtolower($_POST['role'] ?? 'staff'),
            'is_archived' => 0
        ];

        $userModel->create($data);
        $this->redirect('/admin/users');
    }

    public function update($id)
    {
        $userModel = new User();
        
        $data = [
            'name'  => $_POST['name'],
            'email' => $_POST['email'],
            'role'  => strtolower($_POST['role'])
        ];

        if (!empty($_POST['password'])) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $userModel->update($id, $data);
        $this->redirect('/admin/users');
    }

    public function archive($id)
    {
        $userModel = new User();
        $userModel->update($id, ['is_archived' => 1]);
        $this->redirect('/admin/users');
    }

    public function restore($id)
    {
        $userModel = new User();
        $userModel->update($id, ['is_archived' => 0]);
        $this->redirect('/admin/users');
    }

    public function apiArchived()
    {
        $userModel = new User();
        $users = $userModel->where('is_archived', 1);
        
        header('Content-Type: application/json');
        echo json_encode($users);
        exit;
    }

    public function apiDetail($id)
    {
        $userModel = new User();
        $user = $userModel->find($id);
        
        header('Content-Type: application/json');
        echo json_encode($user);
        exit;
    }

    public function delete($id)
    {
        // Keeping for compatibility or specific cases, but UI uses archive
        $userModel = new User();
        $userModel->delete($id);
        $this->redirect('/admin/users');
    }
}
