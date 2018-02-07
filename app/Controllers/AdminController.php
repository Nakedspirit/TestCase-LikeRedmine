<?php
/**
 * Created by PhpStorm.
 * User: Galinka
 * Date: 05.02.2018
 * Time: 0:31
 * @package TestCase
 * @author  Galina Kozyreva <kozyreva.galinka@gmail.com>
 */

namespace TestCase\app\Controllers;
use TestCase\app\Components\AdminBase;

/**
 * Главная страница в админпанели
 */

class AdminController extends AdminBase
{
    /**
     * Action для стартовой страницы "Панель администратора"
     */
    public function actionIndex()
    {
        // Обработка формы
        if (isset($_POST['submit'])) {
            if ($_POST['submit'] == "Вход"){
                $username = $_POST['username'];
                $password = $_POST['password'];
                if ($password == 123 & $username == "admin"){
                    parent::setAdmin();
                    // Перенаправляем пользователя в закрытую часть - кабинет
                    header("Location: ". MY_SERVER);
                }
            }else{
                parent::unsetAdmin();
                header("Location: ". MY_SERVER);
            }
        }
        // Подключаем вид
        require_once(ROOT . '/views/AdminView.php');
        return true;
    }

}
