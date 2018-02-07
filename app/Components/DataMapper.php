<?php
/**
 * Created by PhpStorm.
 * User: Galinka
 * Date: 05.02.2018
 * Time: 0:31
 * @package TestCase
 * @author  Galina Kozyreva <kozyreva.galinka@gmail.com>
 */

namespace TestCase\app\Components;


/**
 * Class DataMapper
 */

class DataMapper
{
    /**
     * @var MyPDO
     */
    public static $db;

    /**
     * @param MyPDO $db
     */
    public static function init(MyPDO $db)
    {
        static::$db = $db;
    }
}