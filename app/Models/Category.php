<?php

namespace App\Models;

class Category extends Model
{
    protected $table = 'categories';

    public function allWithCounts()
    {
        $sql = "SELECT c.*, COUNT(a.id) as item_count 
                FROM {$this->table} c 
                LEFT JOIN assets a ON c.id = a.category_id AND a.is_archived = 0
                WHERE c.is_archived = 0
                GROUP BY c.id";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function allArchivedWithCounts()
    {
        $sql = "SELECT c.*, COUNT(a.id) as item_count 
                FROM {$this->table} c 
                LEFT JOIN assets a ON c.id = a.category_id AND a.is_archived = 0
                WHERE c.is_archived = 1
                GROUP BY c.id";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
