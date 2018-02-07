<?php
/**
 * Created by PhpStorm.
 * User: Galinka
 * Date: 05.02.2018
 * Time: 0:31
 */

namespace TestCase\app\service;

use TestCase\app\domain\Task;

interface TaskService
{
    public function findAll();
    public function findById($id);
    public function findLatestTasksByPageAndLimitOrderByOrd($ord,$page,$limit);
    public function deleteAll();
    public function update(Task $task);
    public function create(Task $task);
    public function count();
}