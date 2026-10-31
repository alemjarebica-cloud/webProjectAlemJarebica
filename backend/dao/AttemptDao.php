<?php

require_once __DIR__ . '/BaseDao.php';

class AttemptDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('attempts', ['user_id', 'quiz_id', 'score']);
    }

    public function getByUser(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM attempts WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }
}