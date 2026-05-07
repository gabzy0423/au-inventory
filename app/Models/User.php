<?php

namespace App\Models;

class User extends Model
{
    protected $table = 'users';

    /**
     * Get all active users except the one with the given ID
     */
    public function allExcept($excludeId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_archived = 0 AND id != ? ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$excludeId]);
        return $stmt->fetchAll();
    }

    /**
     * Get all active administrators
     */
    public function getAdmins()
    {
        $sql = "SELECT * FROM {$this->table} WHERE role = 'admin' AND is_archived = 0";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
