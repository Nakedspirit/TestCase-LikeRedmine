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


use Imagick;
use TestCase\app\Components\ImgResizer;
use TestCase\app\Components\Pagination;
use TestCase\app\domain\Task;
use TestCase\app\service\impl\TaskServiceImpl;

class SiteController
{
    private $taskService;

    /**
     * SiteController constructor.
     */
    public function __construct()
    {
        $this->taskService = new TaskServiceImpl();
    }

    /**
     * Action для главной страницы
     */
    public function actionIndex($ord = "", $page = 1)
    {

        if ($ord == ""){
            $ord = Task::getIdDBName();
        }


        $tasks = $this
            ->taskService
            ->findLatestTasksByPageAndLimitOrderByOrd($ord,$page);
        $total = $this->taskService->count();
        $pagination = new Pagination($total, $page, TaskServiceImpl::SHOW_BY_DEFAULT, 'page-');


        //$tasks = $this->taskService->findAll();
        require_once(ROOT . '/view/site/index.php');
        return true;
    }
    /**
     * Action для страницы "Добавить задачу"
     */
    public function actionCreate()
    {

        // Получаем список категорий для выпадающего списка
//        $categoriesList = Category::getCategoriesListAdmin();


        if (isset($_POST['submit'])) {
            $options[Task::getUsernameDBName()] = $_POST[Task::getUsernameDBName()];
            $options[Task::getEmailDBName()] = $_POST[Task::getEmailDBName()];
            $options[Task::getTextDBName()] = $_POST[Task::getTextDBName()];

            // Флаг ошибок в форме
            $errors = false;
            // При необходимости можно валидировать значения нужным образом
            function validate($options, $str, &$errors){
                if (!isset($options[$str]) ||
                    empty($options[$str])) {
                    $errors[] =  "Заполните поле".$str;
                }
            }
            validate($options, Task::getUsernameDBName(),$errors);
            validate($options, Task::getEmailDBName(),$errors);
            validate($options, Task::getTextDBName(),$errors);
            if ($errors == false) {
                $task = new Task();
                if (is_uploaded_file($_FILES[Task::getImageDBName()]["tmp_name"])){
                        $type = strtolower(strrchr($_FILES[Task::getImageDBName()]['name'],"."));
                        $type = str_replace(".","",$type);
                        print_r($type);
                        $task->setImage($type);
                }else{
                    $task->setImage("");
                }
                $id = $this->taskService->create($task
                    ->setUsername($options[Task::getUsernameDBName()])
                    ->setEmail($options[Task::getEmailDBName()])
                    ->setText($options[Task::getTextDBName()]));
                // Если запись добавлена
                if ($id) {
                    echo "ok";
                    // Проверим, загружалось ли через форму изображение
                    if (is_uploaded_file($_FILES[Task::getImageDBName()]["tmp_name"])
                        &&$task->getImage()!="") {
                        $picture = $_FILES[Task::getImageDBName()];

                        $pic_type = strtolower(strrchr($picture['name'],"."));
                        $pic_name = ROOT.'/..' . "/upload/images/task/{$id}"."$pic_type";
                        
                        move_uploaded_file($picture['tmp_name'], $pic_name);
                        if (true !== ($pic_error = ImgResizer::image_resize($pic_name, $pic_name, 320, 240, 1))) {
                            echo $pic_error;
                            unlink($pic_name);
                        }
                        else echo "OK!";
                        // Если загружалось, переместим его в нужную папке, дадим новое имя
//                        $_SERVER['DOCUMENT_ROOT']
//                        $_FILES[Task::getImageDBName()]["tmp_name"]->adaptiveResizeImage(1024,768);
                        //move_uploaded_file($_FILES[Task::getImageDBName()]["tmp_name"], ROOT.'\\..' . "/upload/images/task/{$id}.{$task->getImage()}");

                    }
                };
                // Перенаправляем пользователя на страницу управлениями задачами
                //header("Location: ". MY_SERVER);
            }
        }

        // Подключаем вид
        require_once(ROOT . '/views/site/create.php');
        return true;
    }
    /**
     * Action для (ajax)
     * @param integer $id <p>id </p>
     */
    public function actionIsDone($id)
    {
        $task = $this->taskService->findById($id);
        $task->setIsDone(!$task->getIsDone());
        echo $this->taskService->update($task);
        return true;
    }
    /**
     * Action для изменения текста(ajax)
     * @param integer $id <p>id </p>
     */
    public function actionEditText($id)
    {
        if (isset($_POST["text"])){
            $task = $this->taskService->findById($id);
//            print_r($task);
            $task->setText($_POST["text"]);
            echo $this->taskService->update($task);
        }
        echo false;
        return true;
    }
}