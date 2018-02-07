<?php
/**
 * Created by PhpStorm.
 * User: Galinka
 * Date: 05.02.2018
 * Time: 0:31
 */

namespace TestCase\app\service\impl;


use TestCase\app\domain\Task;
use TestCase\app\repository\TaskRepository;
use TestCase\app\service\TaskService;

class TaskServiceImpl implements TaskService
{

    private $taskRepository;

    // Количество отображаемых товаров по умолчанию
    const SHOW_BY_DEFAULT = 3;

    public function __construct()
    {
        $this->taskRepository = new TaskRepository();
    }

    public function findAll()
    {
        return $this->taskRepository->findAll();
    }

    public function findById($id)
    {
        return $this->taskRepository->findById($id);
    }

    public function deleteAll()
    {
        return $this->taskRepository->deleteAll();
    }

    public function update(Task $task)
    {
        return $this->taskRepository->update($task);
    }

    public function create(Task $task)
    {
        return $this->taskRepository->create($task);
    }

    public function count()
    {
        return $this->taskRepository->count();
    }

    public function findLatestTasksByPageAndLimitOrderByOrd($ord, $page, $limit = self::SHOW_BY_DEFAULT)
    {
        return $this->taskRepository->findLatestTasksByPageAndLimitOrderByOrd($ord, $page, $limit);
    }
}