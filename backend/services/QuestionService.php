<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/QuestionDao.php';
require_once __DIR__ . '/../dao/QuizDao.php';

class QuestionService extends BaseService
{
    private QuizDao $quizDao;

    public function __construct(?QuestionDao $dao = null, ?QuizDao $quizDao = null)
    {
        parent::__construct($dao ?? new QuestionDao(), 'Question');
        $this->quizDao = $quizDao ?? new QuizDao();
    }

    public function getByQuiz(int $quizId): array
    {
        if ($this->quizDao->getById($quizId) === null) {
            throw new NotFoundException('Quiz not found.');
        }
        return $this->dao->getByQuiz($quizId);
    }

    protected function validate(array $data, ?int $id = null): void
    {
        Validator::required($data, ['quiz_id', 'text']);
        Validator::integer($data['quiz_id'], 'quiz_id', 1, 1000000);
        Validator::string($data['text'], 'text', 5, 500);

        if ($this->quizDao->getById((int) $data['quiz_id']) === null) {
            throw new ValidationException('Quiz does not exist.');
        }
    }
}