<?php

namespace App\Models;

class Notification extends Model {
    protected $table = 'notifications';

    public function getByUser($userId, $limit = 50) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY created_at DESC LIMIT ?");
        $stmt->bindValue(1, $userId, \PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUnreadCount($userId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE user_id = ? AND is_read = 0");
        $stmt->execute([$userId]);
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function getLatestUnread($userId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }

    public function markAsRead($id) {
        return $this->update($id, ['is_read' => 1]);
    }

    public function markAllAsRead($userId) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET is_read = 1 WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }

    public static function createNotification($userId, $title, $message) {
        $model = new self();
        return $model->create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
