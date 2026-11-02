<?php

require_once __DIR__ . '/BaseDao.php';

class QuizDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('quizzes', ['title', 'description', 'category_id', 'created_by']);
    }

    public function getByCategory(int $categoryId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM quizzes WHERE category_id = :category_id ORDER BY id");
        $stmt->execute(['category_id' => $categoryId]);
        return $stmt->fetchAll();
    }
}