<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UserDao.php';
require_once __DIR__ . '/../dao/QuizDao.php';

class UserService extends BaseService
{
    private QuizDao $quizDao;

    public function __construct(?UserDao $dao = null, ?QuizDao $quizDao = null)
    {
        parent::__construct($dao ?? new UserDao(), 'User');
        $this->quizDao = $quizDao ?? new QuizDao();
    }

    public function getAll(): array
    {
        return array_map([$this, 'hidePassword'], parent::getAll());
    }

    public function getById(int $id): array
    {
        return $this->hidePassword(parent::getById($id));
    }

    public function delete(int $id): void
    {
        $this->getById($id);
        if (count($this->quizDao->getByCreator($id)) > 0) {
            throw new ValidationException('User still has quizzes.');
        }
        $this->dao->delete($id);
    }

    protected function validate(array $data, ?int $id = null): void
    {
        Validator::required($data, ['name', 'email']);
        Validator::string($data['name'], 'name', 2, 100);
        Validator::email($data['email']);

        if ($id === null) {
            Validator::required($data, ['password']);
        }
        if (isset($data['password']) && $data['password'] !== '') {
            Validator::string($data['password'], 'password', 8, 72);
        }
        if (isset($data['role']) && !in_array($data['role'], ['admin', 'user'], true)) {
            throw new ValidationException("Field 'role' must be 'admin' or 'user'.");
        }

        $existing = $this->dao->getByEmail(strtolower(trim($data['email'])));
        if ($existing !== null && (int) $existing['id'] !== $id) {
            throw new ValidationException('A user with this email already exists.');
        }
    }

    protected function prepare(array $data): array
    {
        $prepared = [
            'name' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
        ];
        if (isset($data['role'])) {
            $prepared['role'] = $data['role'];
        }
        if (!empty($data['password'])) {
            $prepared['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        return $prepared;
    }

    private function hidePassword(array $user): array
    {
        unset($user['password_hash']);
        return $user;
    }
}