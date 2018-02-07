<?php
/**
 * Created by PhpStorm.
 * User: Galinka
 * Date: 05.02.2018
 * Time: 0:31
 */

namespace TestCase\app;



use TestCase\app\components\DataMapper;
use TestCase\app\components\MyPDO;
use TestCase\app\components\Router;

class App
{
    public function __construct()
    {
        static::main();
    }
    public static function main(){

        // FRONT CONTROLLER
        // Общие настройки

        //require_once(ROOT.'/components/Autoload.php');
        // Вызов Router
        DataMapper::init(new MyPDO());
        $router = new Router();
        $router->run();
    }
}