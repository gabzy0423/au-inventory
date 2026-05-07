<?php

namespace App\Models;

class UsageLog extends Model
{
    protected $table = 'usage_logs';

    /**
     * Get the active usage session for an asset
     */
    public function getActiveByAsset($assetId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE asset_id = ? AND finished_at IS NULL LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$assetId]);
        return $stmt->fetch();
    }

    /**
     * Get all currently deployed items with asset details
     */
    public function getActiveDeployments($limit = 10)
    {
        $sql = "SELECT u.*, a.name, a.tag, a.location as home_location 
                FROM {$this->table} u
                JOIN assets a ON u.asset_id = a.id
                WHERE u.finished_at IS NULL
                ORDER BY u.started_at DESC LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}
