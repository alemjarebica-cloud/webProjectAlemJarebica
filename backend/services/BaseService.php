<?php

require_once __DIR__ . '/../dao/BaseDao.php';
require_once __DIR__ . '/../utils/exceptions.php';
require_once __DIR__ . '/../utils/Validator.php';

abstract class BaseService
{
    protected BaseDao $dao;
    protected string $entityName;

    public function __construct(BaseDao $dao, string $entityName)
    {
        $this->dao = $dao;
        $this->entityName = $entityName;
    }

    public function getAll(): array
    {
        return $this->dao->getAll();
    }

    public function getById(int $id): array
    {
        $entity = $this->dao->getById($id);
        if ($entity === null) {
            throw new NotFoundException("{$this->entityName} not found.");
        }
        return $entity;
    }

    public function add(array $data): array
    {
        $this->validate($data);
        $id = $this->dao->insert($this->prepare($data));
        return $this->getById($id);
    }

    public function update(int $id, array $data): array
    {
        $this->getById($id);
        $this->validate($data, $id);
        $this->dao->update($id, $this->prepare($data));
        return $this->getById($id);
    }

    public function delete(int $id): void
    {
        $this->getById($id);
        $this->dao->delete($id);
    }

    // Child services override these two hooks.
    protected function validate(array $data, ?int $id = null): void
    {
    }

    protected function prepare(array $data): array
    {
        return $data;
    }
}