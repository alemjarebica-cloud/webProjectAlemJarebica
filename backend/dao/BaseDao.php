<?php

require_once __DIR__ . '/../config/Database.php';

abstract class BaseDao
{
    protected PDO $db;
    protected string $table;
    protected array $columns;

    public function __construct(string $table, array $columns)
    {
        $this->db = Database::connect();
        $this->table = $table;
        $this->columns = $columns;
    }

    public function getAll(): array
    {
       $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY id");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function insert(array $data): int
    {
        $data = $this->filterColumns($data);
        $names = array_keys($data);
        $columns = implode(', ', $names);
        $placeholders = implode(', ', array_map(fn($n) => ":$n", $names));

        $stmt = $this->db->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $data = $this->filterColumns($data);
        $set = implode(', ', array_map(fn($n) => "$n = :$n", array_keys($data)));

        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE {$this->table} SET $set WHERE id = :id");
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    private function filterColumns(array $data): array
    {
        $data = array_intersect_key($data, array_flip($this->columns));
        if (empty($data)) {
            throw new InvalidArgumentException('No valid columns provided.');
        }
        return $data;
    }
}