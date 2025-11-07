<?php

namespace Nebatech\Core;

use Nebatech\Core\Database;

abstract class Model
{
    protected string $table;
    protected string $primaryKey = 'id';
    protected array $fillable = [];
    protected array $hidden = [];
    
    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
        $result = Database::fetch($sql, ['id' => $id]);
        
        return $result ? $this->hideAttributes($result) : null;
    }

    public function findBy(string $column, $value): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1";
        $result = Database::fetch($sql, ['value' => $value]);
        
        return $result ? $this->hideAttributes($result) : null;
    }

    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $results = Database::fetchAll($sql);
        
        return array_map([$this, 'hideAttributes'], $results);
    }

    public function where(string $column, $value): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :value";
        $results = Database::fetchAll($sql, ['value' => $value]);
        
        return array_map([$this, 'hideAttributes'], $results);
    }

    public function create(array $data): int
    {
        $filteredData = $this->filterFillable($data);
        
        if (in_array('uuid', $this->fillable) && !isset($filteredData['uuid'])) {
            $filteredData['uuid'] = $this->generateUuid();
        }
        
        return Database::insert($this->table, $filteredData);
    }

    public function update(int $id, array $data): int
    {
        $filteredData = $this->filterFillable($data);
        return Database::update(
            $this->table,
            $filteredData,
            "{$this->primaryKey} = :id",
            ['id' => $id]
        );
    }

    public function delete(int $id): int
    {
        return Database::delete($this->table, "{$this->primaryKey} = :id", ['id' => $id]);
    }

    public function paginate(int $page = 1, int $perPage = 15): array
    {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT * FROM {$this->table} LIMIT :limit OFFSET :offset";
        $results = Database::fetchAll($sql, [
            'limit' => $perPage,
            'offset' => $offset
        ]);
        
        $countSql = "SELECT COUNT(*) as total FROM {$this->table}";
        $total = Database::fetch($countSql)['total'];
        
        return [
            'data' => array_map([$this, 'hideAttributes'], $results),
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'last_page' => ceil($total / $perPage),
        ];
    }

    protected function filterFillable(array $data): array
    {
        if (empty($this->fillable)) {
            return $data;
        }
        
        return array_intersect_key($data, array_flip($this->fillable));
    }

    protected function hideAttributes(array $data): array
    {
        if (empty($this->hidden)) {
            return $data;
        }
        
        foreach ($this->hidden as $attribute) {
            unset($data[$attribute]);
        }
        
        return $data;
    }

    protected function generateUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}
