<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\User;

class ProfileController extends BaseController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }

        $userModel = new User();
        $user = $userModel->find($_SESSION['user_id']);

        $this->render('admin/profile/index', [
            'user' => $user
        ]);
    }

    public function update()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }

        $id = $_SESSION['user_id'];
        $userModel = new User();
        
        $data = [
            'name' => $_POST['name'] ?? ''
        ];

        // Handle Password Update
        if (!empty($_POST['password'])) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        // Handle Profile Picture Upload
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['profile_image']['tmp_name'];
            $fileName = $_FILES['profile_image']['name'];
            $fileSize = $_FILES['profile_image']['size'];
            $fileType = $_FILES['profile_image']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = __DIR__ . '/../../../public/uploads/profiles/';
            
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $data['profile_image'] = $newFileName;
                // Update session name if changed
                $_SESSION['profile_image'] = $newFileName;
            }
        }

        if ($userModel->update($id, $data)) {
            $_SESSION['name'] = $data['name'];
            $this->redirect('/admin/profile?success=1');
        } else {
            $this->redirect('/admin/profile?error=1');
        }
    }
}
