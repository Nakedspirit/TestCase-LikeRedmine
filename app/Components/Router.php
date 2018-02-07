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
use TestCase\app\Сontrollers;

/**
 * Компонент для работы с маршрутами
 */
class Router
{

    private $routes;
    public function __construct()
    {
        $routesPath = ROOT . '\configs\routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * Возвращает строку запроса
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
        return "";
    }

    /**
     * Метод для обработки запроса
     */
    public function run()
    {

        $uri = $this->getURI();
        $uri = preg_replace("~testtask/app~", "", $uri);

        // Проверяем наличие запроса в массиве маршрутов (routes.php)
        foreach ($this->routes as $uriPattern => $path) {
            // Сравниваем $uriPattern и $uri
            if (preg_match("~$uriPattern~", $uri)) {
                // Получаем внутренний путь из внешнего согласно правилу.
                $uri = preg_replace("~//~", "/",$uri);
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                $segments = explode('/', $internalRoute);
                if ($uri != ""){
                    array_shift($segments);
                }
                $controllerName = array_shift($segments) . "Controller";

                $controllerName = ucfirst($controllerName);
                $actionName = 'action' . ucfirst(array_shift($segments));
                $parameters = $segments;
                // Подключить файл класса-контроллера
                $controllerFile = ROOT . '/controller/' .
                        $controllerName . '.php';

                // Создать объект, вызвать метод (т.е. action)
                $controllerName = "TestCase\\app\\controller\\".$controllerName;
                $controllerObject = new $controllerName;

                /* Вызываем необходимый метод ($actionName) у определенного
                 * класса ($controllerObject) с заданными ($parameters) параметрами
                 */
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                // Если метод контроллера успешно вызван, завершаем работу роутера
                if ($result != null) {
                    break;
                }
            }
        }

    }

}
