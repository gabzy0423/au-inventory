<?php

namespace App\Models;

use App\Core\Database;

abstract class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getConnection();
        // Automatically determine table name if not set
        if (!isset($this->table)) {
            $class = (new \ReflectionClass($this))->getShortName();
            $this->table = strtolower($class) . 's';
        }
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function where($column, $value) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = ?");
        $stmt->execute([$value]);
        return $stmt->fetchAll();
    }

    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function countBy($column, $value) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE {$column} = ?");
        $stmt->execute([$value]);
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function update($id, $data) {
        $fields = array_keys($data);
        $setClause = implode(' = ?, ', $fields) . ' = ?';
        
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE id = ?";
        $params = array_values($data);
        $params[] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function create($data) {
        $fields = array_keys($data);
        $placeholders = implode(', ', array_fill(0, count($fields), '?'));
        $columns = implode(', ', $fields);

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($data));
        return $this->db->lastInsertId();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getDb() {
        return $this->db;
    }
}
