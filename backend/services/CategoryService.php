<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/CategoryDao.php';
require_once __DIR__ . '/../dao/QuizDao.php';

class CategoryService extends BaseService
{
    private QuizDao $quizDao;

    public function __construct(?CategoryDao $dao = null, ?QuizDao $quizDao = null)
    {
        parent::__construct($dao ?? new CategoryDao(), 'Category');
        $this->quizDao = $quizDao ?? new QuizDao();
    }

    protected function validate(array $data, ?int $id = null): void
    {
        Validator::required($data, ['name']);
        Validator::string($data['name'], 'name', 2, 100);

        $existing = $this->dao->getByName(trim($data['name']));
        if ($existing !== null && (int) $existing['id'] !== $id) {
            throw new ValidationException('A category with this name already exists.');
        }
    }

    public function delete(int $id): void
    {
        $this->getById($id);
        if (count($this->quizDao->getByCategory($id)) > 0) {
            throw new ValidationException('Category still has quizzes.');
        }
        $this->dao->delete($id);
    }
}