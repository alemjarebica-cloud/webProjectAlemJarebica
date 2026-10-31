<?php

require_once __DIR__ . '/BaseDao.php';

class AnswerDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('answers', ['question_id', 'text', 'is_correct']);
    }

    public function getByQuestion(int $questionId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM answers WHERE question_id = :question_id ORDER BY id");
        $stmt->execute(['question_id' => $questionId]);
        return $stmt->fetchAll();
    }
}