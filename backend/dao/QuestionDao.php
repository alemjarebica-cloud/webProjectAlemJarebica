<?php

require_once __DIR__ . '/BaseDao.php';

class QuestionDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('questions', ['quiz_id', 'text']);
    }

    public function getByQuiz(int $quizId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE quiz_id = :quiz_id ORDER BY id");
        $stmt->execute(['quiz_id' => $quizId]);
        return $stmt->fetchAll();
    }
}