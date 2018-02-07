<?php
/**
 * Created by PhpStorm.
 * User: Galinka
 * Date: 05.02.2018
 * Time: 0:31
 */

namespace TestCase\app\repository;

//interface ICRUDRepository
//{
//    public function findAll();
//    public function findById($id);
//    public function deleteAll();
//    public function update($value);
//    public function count();
//    public function create($value);
//}

use TestCase\app\components\DataMapper;
use TestCase\app\components\MyPDO;

abstract class CRUDRepository extends DataMapper
{
    protected $table;
    /**
     * @return CRUDRepository
     */
    public function __construct()
    {
        $tableClass = str_replace(
            "Repository",
            "",
            $this->getClassName()
        );
        $this->table = strtolower($tableClass);
    }
    public function getClassName() {
        $path = explode('\\', get_class($this));
        return array_pop($path);
    }

    /**
     * Возвращает Statement
     * @return array <p>Информация о обьекте</p>
     */
    public function findAll()
    {
        $st = static::$db->query(
            'SELECT * FROM '. $this->table
        );
        // Получение и возврат результатов
        $i = 0;
        $list = array();
        while ($list[$i++] = $st->fetch()) {}

        return $list;
    }
    /**
     * Возвращает обьект с указанным id
     * @param integer $id <p>id обьекта</p>
     * @return array <p>Массив с информацией о обьекте</p>
     */
    public function findById($id)
    {
        $st = static::$db->prepare(
            'SELECT * FROM '. $this->table.
            ' WHERE id = :id '
        );
        $st->bindParam(':id', $id, MyPDO::PARAM_INT);
        // Указываем, что хотим получить данные в виде массива
        $st->setFetchMode(MyPDO::FETCH_ASSOC);
        // Выполнение коменды
        $st->execute();
//        print_r($st);
        // Получение и возврат результатов
        return $st->fetch();
    }
    /**
     * Удаляет все обьекты
     * @return boolean <p>Результат выполнения метода</p>
     */
    public function deleteAll()
    {
        $st = static::$db->prepare(
        'DELETE FROM '. $this->table
        );
        return $st->execute();
    }
    /**
     * Удаляет обьект с указанным id
     * @param integer $id <p>id обьекта</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public function deleteById($id)
    {
        $st = static::$db->prepare(
            'DELETE FROM '. $this->table.
            ' WHERE id = :id '
        );
        $st->bindParam(':id', $id, PDO::PARAM_INT);
        return $st->execute();
    }
    /**
     * Возвращаем количество записей в таблице
     * @return integer
     */
    public function count()
    {
        $st = static::$db->prepare(
            'SELECT COUNT(*) FROM '. $this->table
        );
        $st->execute();
        return $st->fetch()[0];
    }
}