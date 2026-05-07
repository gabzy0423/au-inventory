<?php

namespace App\Models;

class Asset extends Model
{
    protected $table = 'assets';

    /**
     * Get asset with its category name and current report status
     */
    public function allWithCategory()
    {
        $sql = "SELECT a.*, c.name as category_name, c.color as category_color,
                (SELECT status FROM reports WHERE asset_id = a.id AND status NOT IN ('Fixed', 'Resolved') ORDER BY reported_at DESC LIMIT 1) as report_status
                FROM {$this->table} a 
                LEFT JOIN categories c ON a.category_id = c.id 
                WHERE a.is_archived = 0
                ORDER BY a.id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Get single asset with its category name and current report status by ID
     */
    public function findWithCategory($id)
    {
        $sql = "SELECT a.*, c.name as category_name, c.color as category_color,
                (SELECT status FROM reports WHERE asset_id = a.id AND status NOT IN ('Fixed', 'Resolved') ORDER BY reported_at DESC LIMIT 1) as report_status
                FROM {$this->table} a 
                LEFT JOIN categories c ON a.category_id = c.id 
                WHERE a.id = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function setArchiveByCategory($categoryId, $status)
    {
        $sql = "UPDATE {$this->table} 
            SET is_archived = ? 
            WHERE category_id = ?";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $categoryId]);
    }

    /**
     * Get archived assets with their category name
     */
    public function allArchivedWithCategory()
    {
        $sql = "SELECT a.*, c.name as category_name, c.color as category_color 
                FROM {$this->table} a 
                LEFT JOIN categories c ON a.category_id = c.id 
                WHERE a.is_archived = 1
                ORDER BY a.id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Get recently reported assets for the dashboard
     */
    public function getRecentReports($limit = 5)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE status IN ('Damaged', 'Under Repair') 
                ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    /**
     * Get items in the maintenance queue (Joined with Reports)
     */
    public function getMaintenanceQueue($limit = 5)
    {
        $sql = "SELECT a.*, r.id as report_id, r.title, r.description as issue, r.status as report_status 
                FROM {$this->table} a
                INNER JOIN reports r ON a.id = r.asset_id
                WHERE r.status NOT IN ('Fixed', 'Resolved') AND a.is_archived = 0
                ORDER BY r.reported_at ASC LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    /**
     * Get assets by category ID
     */
    public function getByCategory($categoryId)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE category_id = ? AND is_archived = 0 
                ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }

    /**
     * Get assets by location name with category info
     */
    public function getByLocation($locationName)
    {
        $sql = "SELECT a.*, c.name as category_name, c.color as category_color,
                (SELECT status FROM reports WHERE asset_id = a.id AND status NOT IN ('Fixed', 'Resolved') ORDER BY reported_at DESC LIMIT 1) as report_status
                FROM {$this->table} a 
                LEFT JOIN categories c ON a.category_id = c.id 
                WHERE a.location = ? AND a.is_archived = 0 
                ORDER BY a.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$locationName]);
        return $stmt->fetchAll();
    }
    /**
     * Get recent assets with their category name
     */
    public function getRecentWithCategory($limit = 5)
    {
        $sql = "SELECT a.*, c.name as category_name, c.color as category_color 
                FROM {$this->table} a 
                LEFT JOIN categories c ON a.category_id = c.id 
                WHERE a.is_archived = 0 
                ORDER BY a.id DESC LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    /**
     * Count active (unarchived) assets
     */
    public function countActive()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE is_archived = 0");
        $result = $stmt->fetch();
        return $result['total'];
    }

    /**
     * Count active assets by status
     */
    public function countActiveByStatus($status)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE status = ? AND is_archived = 0");
        $stmt->execute([$status]);
        $result = $stmt->fetch();
        return $result['total'];
    }
    /**
     * Get active assets grouped by location
     */
    public function getAssetsByLocation()
    {
        $sql = "SELECT location, COUNT(*) as count 
                FROM {$this->table} 
                WHERE is_archived = 0 
                GROUP BY location 
                ORDER BY count DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
