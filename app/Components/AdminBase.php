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
 * Общая логика для контроллеров, которые 
 * используются в панели администратора
 */

abstract class AdminBase
{

    /**
     * Проверка пользователя на то, является ли он администратором
     * @return boolean
     */

    public static function checkAdmin()
    {
        if (isset($_SESSION['X-Auth-Token'])) {
            if($_SESSION['X-Auth-Token'] == "admin123"){
                return true;
            }
        }
        return false;
    }
    
    /**
     * Делает пользователя администратором
     * @return boolean
     */

    protected static function setAdmin()
    {
        $_SESSION['X-Auth-Token'] = "admin123";
    }

    /**
     * И наоборот
     * @return boolean
     */ 

    protected static function unsetAdmin()
    {
        if (isset($_SESSION['X-Auth-Token'])) {
            unset($_SESSION['X-Auth-Token']);
        }
    }
}
