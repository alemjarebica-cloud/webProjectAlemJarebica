<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/AttemptDao.php';
require_once __DIR__ . '/../dao/UserDao.php';
require_once __DIR__ . '/../dao/QuizDao.php';
require_once __DIR__ . '/../dao/QuestionDao.php';

class AttemptService extends BaseService
{
    private UserDao $userDao;
    private QuizDao $quizDao;
    private QuestionDao $questionDao;

    public function __construct(
        ?AttemptDao $dao = null,
        ?UserDao $userDao = null,
        ?QuizDao $quizDao = null,
        ?QuestionDao $questionDao = null
    ) {
        parent::__construct($dao ?? new AttemptDao(), 'Attempt');
        $this->userDao = $userDao ?? new UserDao();
        $this->quizDao = $quizDao ?? new QuizDao();
        $this->questionDao = $questionDao ?? new QuestionDao();
    }

    public function getByUser(int $userId): array
    {
        if ($this->userDao->getById($userId) === null) {
            throw new NotFoundException('User not found.');
        }
        return $this->dao->getByUser($userId);
    }

    protected function validate(array $data, ?int $id = null): void
    {
        Validator::required($data, ['user_id', 'quiz_id', 'score']);
        Validator::integer($data['user_id'], 'user_id', 1, 1000000);
        Validator::integer($data['quiz_id'], 'quiz_id', 1, 1000000);
        Validator::integer($data['score'], 'score', 0, 1000000);

        if ($this->userDao->getById((int) $data['user_id']) === null) {
            throw new ValidationException('User does not exist.');
        }
        if ($this->quizDao->getById((int) $data['quiz_id']) === null) {
            throw new ValidationException('Quiz does not exist.');
        }

        $questionCount = count($this->questionDao->getByQuiz((int) $data['quiz_id']));
        if ((int) $data['score'] > $questionCount) {
            throw new ValidationException("Score cannot be higher than the number of questions ($questionCount).");
        }
    }
}