<?php

namespace App\Models;

class Room extends Model
{
    protected $table = 'rooms';

    public function allWithCounts()
    {
        $sql = "SELECT r.*, COUNT(a.id) as item_count 
                FROM {$this->table} r 
                LEFT JOIN assets a ON r.name = a.location AND a.is_archived = 0
                WHERE r.is_archived = 0
                GROUP BY r.id";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function allArchivedWithCounts()
    {
        $sql = "SELECT r.*, COUNT(a.id) as item_count 
                FROM {$this->table} r 
                LEFT JOIN assets a ON r.name = a.location AND a.is_archived = 1
                WHERE r.is_archived = 1
                GROUP BY r.id";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}

