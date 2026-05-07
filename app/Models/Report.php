<?php

namespace App\Models;

class Report extends Model
{
    protected $table = 'reports';

    /**
     * Get pending reports for a specific asset
     */
    public function getPendingByAsset($assetId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE asset_id = ? AND status NOT IN ('Resolved', 'Merged') ORDER BY reported_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$assetId]);
        return $stmt->fetchAll();
    }

    /**
     * Get all reports for a specific user with asset details
     */
    public function getAllByUser($userId)
    {
        $sql = "SELECT r.*, a.name as asset_name, a.tag as asset_tag,
                       u.name as reported_by_name, u.profile_image as reported_by_image,
                       f.name as fixed_by_name, f.profile_image as fixed_by_image
                FROM {$this->table} r 
                JOIN assets a ON r.asset_id = a.id 
                LEFT JOIN users u ON r.user_id = u.id
                LEFT JOIN users f ON r.fixed_by = f.id
                WHERE r.user_id = ? AND a.is_archived = 0 AND r.status != 'Resolved'
                ORDER BY r.reported_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    /**
     * Get all reports with asset and user details (Incident Log)
     */
    public function getAllWithAssets()
    {
        $sql = "SELECT r.*, a.name as asset_name, a.tag as asset_tag,
                       u.name as reported_by_name, u.profile_image as reported_by_image,
                       f.name as fixed_by_name, f.profile_image as fixed_by_image
                FROM {$this->table} r 
                JOIN assets a ON r.asset_id = a.id 
                LEFT JOIN users u ON r.user_id = u.id
                LEFT JOIN users f ON r.fixed_by = f.id
                WHERE a.is_archived = 0 AND r.status != 'Resolved'
                ORDER BY r.reported_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Get all resolved reports with asset and user details
     */
    public function getResolvedWithAssets()
    {
        $sql = "SELECT r.*, a.name as asset_name, a.tag as asset_tag,
                       u.name as reported_by_name, u.profile_image as reported_by_image,
                       f.name as fixed_by_name, f.profile_image as fixed_by_image
                FROM {$this->table} r 
                JOIN assets a ON r.asset_id = a.id 
                LEFT JOIN users u ON r.user_id = u.id
                LEFT JOIN users f ON r.fixed_by = f.id
                WHERE r.status = 'Resolved'
                ORDER BY r.reported_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getVaultReports()
    {
        $sql = "SELECT r.*, a.name as asset_name, a.tag as asset_tag,
                       u.name as reported_by_name, u.profile_image as reported_by_image,
                       f.name as fixed_by_name, f.profile_image as fixed_by_image
                FROM {$this->table} r 
                JOIN assets a ON r.asset_id = a.id 
                LEFT JOIN users u ON r.user_id = u.id
                LEFT JOIN users f ON r.fixed_by = f.id
                WHERE r.status = 'Resolved'
                ORDER BY r.reported_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Get resolved reports with asset and user details, filtered by date
     */
    public function getResolvedFiltered($startDate = null, $endDate = null)
    {
        $sql = "SELECT r.*, a.name as asset_name, a.tag as asset_tag,
                       u.name as reported_by_name, u.profile_image as reported_by_image,
                       f.name as fixed_by_name, f.profile_image as fixed_by_image
                FROM {$this->table} r 
                JOIN assets a ON r.asset_id = a.id 
                LEFT JOIN users u ON r.user_id = u.id
                LEFT JOIN users f ON r.fixed_by = f.id
                WHERE r.status = 'Resolved'";
        
        $params = [];
        if ($startDate) {
            $sql .= " AND DATE(r.reported_at) >= ?";
            $params[] = $startDate;
        }
        if ($endDate) {
            $sql .= " AND DATE(r.reported_at) <= ?";
            $params[] = $endDate;
        }

        $sql .= " ORDER BY r.reported_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Get only pending/maintenance reports with asset details (Alias for getPendingWithAssets)
     */
    public function getAllActiveWithAssets()
    {
        return $this->getPendingWithAssets();
    }

    /**
     * Get only pending/maintenance reports with asset details
     */
    public function getPendingWithAssets()
    {
        $sql = "SELECT r.*, a.name as asset_name, a.tag as asset_tag,
                       u.name as reported_by_name, u.profile_image as reported_by_image
                FROM {$this->table} r 
                JOIN assets a ON r.asset_id = a.id 
                LEFT JOIN users u ON r.user_id = u.id
                WHERE r.status != 'Resolved' AND r.status != 'Merged' AND a.is_archived = 0
                ORDER BY r.reported_at ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Get pending reports for a specific user
     */
    public function getPendingByUser($userId)
    {
        $sql = "SELECT r.*, a.name as asset_name, a.tag as asset_tag,
                       u.name as reported_by_name, u.profile_image as reported_by_image
                FROM {$this->table} r 
                JOIN assets a ON r.asset_id = a.id 
                LEFT JOIN users u ON r.user_id = u.id
                WHERE r.user_id = ? AND r.status != 'Resolved' AND r.status != 'Merged' AND a.is_archived = 0
                ORDER BY r.reported_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    /**
     * Get resolved reports for a specific user
     */
    public function getResolvedByUser($userId)
    {
        $sql = "SELECT r.*, a.name as asset_name, a.tag as asset_tag,
                       u.name as reported_by_name, u.profile_image as reported_by_image,
                       f.name as fixed_by_name, f.profile_image as fixed_by_image
                FROM {$this->table} r 
                JOIN assets a ON r.asset_id = a.id 
                LEFT JOIN users u ON r.user_id = u.id
                LEFT JOIN users f ON r.fixed_by = f.id
                WHERE r.user_id = ? AND r.status = 'Resolved'
                ORDER BY r.reported_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    /**

     * Get resolved reports for a specific asset
     */
    public function getResolvedByAsset($assetId)
    {
        $sql = "SELECT r.*, u.name as reported_by_name, f.name as fixed_by_name
                FROM {$this->table} r 
                LEFT JOIN users u ON r.user_id = u.id
                LEFT JOIN users f ON r.fixed_by = f.id
                WHERE r.asset_id = ? AND r.status = 'Resolved'
                ORDER BY r.resolved_at DESC, r.reported_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$assetId]);
        return $stmt->fetchAll();
    }
}
