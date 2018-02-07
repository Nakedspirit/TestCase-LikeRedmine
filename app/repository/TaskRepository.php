<?php
/**
 * Created by PhpStorm.
 * User: Galinka
 * Date: 05.02.2018
 * Time: 0:31
 */

namespace TestCase\app\repository;

use TestCase\app\Components\MyPDO;
use TestCase\app\domain\Task;

class TaskRepository extends CRUDRepository
{
//    public function findAll();
//    public function findById($id);
//    public function deleteAll();
    /**
     * Возвращает массив последних тaсков
     * @param $ord
     * @param int|type $page [optional] <p>Номер текущей страницы</p>
     * @param $limit
     * @return array <p>Массив с задачами</p>
     * @internal param type $count [optional] <p>Количество</p>
     */
    public function findLatestTasksByPageAndLimitOrderByOrd($ord, $page = 1, $limit)
    {
        // Смещение (для запроса)
        $offset = ($page - 1) * $limit;
//        echo "_".$ord."_";
        // Используется подготовленный запрос
        $st = static::$db->prepare(
            'SELECT * FROM '. Task::getTaskDBName().
            ' ORDER BY '.$ord.' ASC LIMIT :limit OFFSET :offset');
//        $st->bindParam(':ord', $ord, MyPDO::PARAM);
        $st->bindParam(':limit', $limit, MyPDO::PARAM_INT);
        $st->bindParam(':offset', $offset, MyPDO::PARAM_INT);

        // Указываем, что хотим получить данные в виде массива
        $st->setFetchMode(MyPDO::FETCH_ASSOC);
        $st->execute();
        // Получение и возврат результатов
        $i = 0;
        $tasks = array();
        while ($TaskArray = $st->fetch()){
            $tasks[$i] = new Task($TaskArray[Task::getIdDBName()],
                $TaskArray[Task::getUsernameDBName()],
                $TaskArray[Task::getEmailDBName()],
                $TaskArray[Task::getTextDBName()],
                $TaskArray[Task::getImageDBName()],
                $TaskArray[Task::getIsDoneDBName()]);
            $i++;
        }
        return $tasks;
    }
    public function findAll()
    {
        $listOfTaskArrays = parent::findAll();
        $i = 0;
        $tasks = array();
        while ($TaskArray = $listOfTaskArrays[$i]){
            $tasks[$i] = new Task($TaskArray[Task::getIdDBName()],
                $TaskArray[Task::getUsernameDBName()],
                $TaskArray[Task::getEmailDBName()],
                $TaskArray[Task::getTextDBName()],
                $TaskArray[Task::getImageDBName()],
                $TaskArray[Task::getIsDoneDBName()]);
            $i++;
        }
        return $tasks;
    }
    public function update(Task $task)
    {
        $st = static::$db->prepare(
            'UPDATE '.Task::getTaskDBName() .
            ' SET '.Task::getUsernameDBName().' = :'.Task::getUsernameDBName().
            ', '.Task::getEmailDBName().' = :'.Task::getEmailDBName().
            ', '.Task::getTextDBName().' = :'.Task::getTextDBName().
            ', '.Task::getIsDoneDBName().' = :'.Task::getIsDoneDBName().
            ', '.Task::getImageDBName().' = :'.Task::getImageDBName().
            ' WHERE '.Task::getIdDBName().' = :'.Task::getIdDBName()
        );
        print_r($task);
        return $st->execute(array(
            ':'.Task::getIdDBName() => $task->getId(),
            ':'.Task::getUsernameDBName() => $task->getUsername(),
            ':'.Task::getEmailDBName() => $task->getEmail(),
            ':'.Task::getTextDBName() => $task->getText(),
            ':'.Task::getIsDoneDBName() => $task->getIsDone(),
            ':'.Task::getImageDBName() => $task->getImage()
        ));
    }
    /**
     * @param Task $task
     */
    public function create(Task $task)
    {
//        echo 'insert into '.$task::getTaskDBName() .
//            ' set '
//            .$task::getIdDBName().' = :'.$task::getIdDBName().
//            .$task::getUsernameDBName().' = :'.$task::getUsernameDBName().
//            ', '.$task::getEmailDBName().' = :'.$task::getEmailDBName().
//            ', '.$task::getTextDBName().' = :'.$task::getTextDBName().
//            ', '.$task::getIsDoneDBName().' = :'.$task::getIsDoneDBName().
//            ', '.$task::getImageDBName().' = :'.$task::getImageDBName();
//        echo "<br>";
//
//        print_r(array(
//            ':'.Task::getIdDBName() => 3,
//            ':'.Task::getUsernameDBName() => $task->getUsername(),
//            ':'.Task::getEmailDBName() => $task->getEmail(),
//            ':'.Task::getTextDBName() => $task->getText(),
//            ':'.Task::getIsDoneDBName() => $task->getIsDone(),
//            ':'.Task::getImageDBName() => $task->getImage()
//        ));
        $st = static::$db->prepare(
            'insert into '.$task::getTaskDBName() .
            ' set '
            .$task::getUsernameDBName().' = :'.$task::getUsernameDBName().
            ', '.$task::getEmailDBName().' = :'.$task::getEmailDBName().
            ', '.$task::getTextDBName().' = :'.$task::getTextDBName().
            ', '.$task::getIsDoneDBName().' = :'.$task::getIsDoneDBName().
            ', '.$task::getImageDBName().' = :'.$task::getImageDBName()
        );
        if ($st->execute(array(
            ':'.Task::getUsernameDBName() => $task->getUsername(),
            ':'.Task::getEmailDBName() => $task->getEmail(),
            ':'.Task::getTextDBName() => $task->getText(),
            ':'.Task::getIsDoneDBName() => $task->getIsDone(),
            ':'.Task::getImageDBName() =>  $task->getImage()
        ))) {
            // Если запрос выполенен успешно, возвращаем id добавленной записи
            return static::$db->lastInsertId();
        }
        // Иначе возвращаем 0
        return 0;
    }
    public function findById($id)
    {
        $taskArray = parent::findById($id);
        $task = new Task(
            $taskArray[Task::getIdDBName()],
            $taskArray[Task::getUsernameDBName()],
            $taskArray[Task::getEmailDBName()],
            $taskArray[Task::getTextDBName()],
            $taskArray[Task::getImageDBName()],
            $taskArray[Task::getIsDoneDBName()]
        );

        return $task;
    }
}