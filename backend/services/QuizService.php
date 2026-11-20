<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/QuizDao.php';
require_once __DIR__ . '/../dao/CategoryDao.php';
require_once __DIR__ . '/../dao/UserDao.php';

class QuizService extends BaseService
{
    private CategoryDao $categoryDao;
    private UserDao $userDao;

    public function __construct(?QuizDao $dao = null, ?CategoryDao $categoryDao = null, ?UserDao $userDao = null)
    {
        parent::__construct($dao ?? new QuizDao(), 'Quiz');
        $this->categoryDao = $categoryDao ?? new CategoryDao();
        $this->userDao = $userDao ?? new UserDao();
    }

    public function getByCategory(int $categoryId): array
    {
        if ($this->categoryDao->getById($categoryId) === null) {
            throw new NotFoundException('Category not found.');
        }
        return $this->dao->getByCategory($categoryId);
    }

    protected function validate(array $data, ?int $id = null): void
    {
        Validator::required($data, ['title', 'category_id', 'created_by']);
        Validator::string($data['title'], 'title', 3, 150);
        if (isset($data['description'])) {
            Validator::string($data['description'], 'description', 0, 1000);
        }
        Validator::integer($data['category_id'], 'category_id', 1, 1000000);
        Validator::integer($data['created_by'], 'created_by', 1, 1000000);

        if ($this->categoryDao->getById((int) $data['category_id']) === null) {
            throw new ValidationException('Category does not exist.');
        }
        if ($this->userDao->getById((int) $data['created_by']) === null) {
            throw new ValidationException('Author does not exist.');
        }
    }
}