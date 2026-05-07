<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Notification;

class NotificationController extends BaseController
{
    public function index()
    {
        $notificationModel = new Notification();
        $userId = $_SESSION['user_id'];
        
        $notifications = $notificationModel->getByUser($userId);
        
        $this->render('admin/notifications/index', [
            'notifications' => $notifications
        ], 'admin/layouts/app');
    }

    public function markRead($id)
    {
        $notificationModel = new Notification();
        $notificationModel->markAsRead($id);
        
        $this->redirect('/admin/notifications');
    }

    public function markAllRead()
    {
        $notificationModel = new Notification();
        $notificationModel->markAllAsRead($_SESSION['user_id']);
        
        $this->redirect('/admin/notifications');
    }
}
