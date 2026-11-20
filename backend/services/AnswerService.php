<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/AnswerDao.php';
require_once __DIR__ . '/../dao/QuestionDao.php';

class AnswerService extends BaseService
{
    private QuestionDao $questionDao;

    public function __construct(?AnswerDao $dao = null, ?QuestionDao $questionDao = null)
    {
        parent::__construct($dao ?? new AnswerDao(), 'Answer');
        $this->questionDao = $questionDao ?? new QuestionDao();
    }

    public function getByQuestion(int $questionId): array
    {
        if ($this->questionDao->getById($questionId) === null) {
            throw new NotFoundException('Question not found.');
        }
        return $this->dao->getByQuestion($questionId);
    }

    protected function validate(array $data, ?int $id = null): void
    {
        Validator::required($data, ['question_id', 'text']);
        Validator::integer($data['question_id'], 'question_id', 1, 1000000);
        Validator::string($data['text'], 'text', 1, 255);

        if ($this->questionDao->getById((int) $data['question_id']) === null) {
            throw new ValidationException('Question does not exist.');
        }

        if ($this->toBool($data['is_correct'] ?? false)) {
            foreach ($this->dao->getByQuestion((int) $data['question_id']) as $answer) {
                if ((int) $answer['is_correct'] === 1 && (int) $answer['id'] !== $id) {
                    throw new ValidationException('This question already has a correct answer.');
                }
            }
        }
    }

    protected function prepare(array $data): array
    {
        return [
            'question_id' => (int) $data['question_id'],
            'text' => trim($data['text']),
            'is_correct' => $this->toBool($data['is_correct'] ?? false) ? 1 : 0,
        ];
    }

    private function toBool(mixed $value): bool
    {
        $bool = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if ($bool === null) {
            throw new ValidationException("Field 'is_correct' must be true or false.");
        }
        return $bool;
    }
}