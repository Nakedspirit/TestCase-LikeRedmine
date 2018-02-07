<?php
/**
 * Created by PhpStorm.
 * User: Galinka
 * Date: 05.02.2018
 * Time: 0:31
 * @package TestCase
 * @author  Galina Kozyreva <kozyreva.galinka@gmail.com>
 */


namespace TestCase\app\domain;

/**
 * Class Task
 * Задачи состоят из:
 * имени пользователя;
 * е-mail;
 * текста задачи;
 * картинки;
 * @package TestCase\app\domain
 */
class Task
{
    private $id;
    /**
     * @var string имя пользователя
     */
    private $username = "";
    /**
     * @var string е-mail пользователя
     */
    private $email = "";
    /**
     * @var string  текст задачи
     */
    private $text = "";
    /**
     * @var object изображение задачи
     */
    private $image = "";
    /**
     * @var object изображение задачи
     */
    private $isDone = false;
    public function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }
    /**
     * Task constructor.
     * @param $id
     * @param string $username
     * @param string $email
     * @param string $text
     * @param object $image
     * @param $isDone
     */
    public function __construct6($id,$username, $email, $text, $image,$isDone)
    {
        $this->isDone = $isDone;
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->text = $text;
        $this->image = $image;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return object
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param object $image
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }
    /**
     * @return object
     */
    public function getIsDone()
    {
        return $this->isDone;
    }

    /**
     * @param object $isDone
     */
    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;
        return $this;
    }

    /**
     * @return string
     */
    public static function getUsernameDBName()
    {
        return "username";
    }
    /**
     * @return string
     */
    public static function getEmailDBName()
    {
        return "email";
    }
    /**
     * @return string
     */
    public static function getTextDBName()
    {
        return "text";
    }
    /**
     * @return string
     */
    public static function getImageDBName()
    {
        return "image";
    }
    /**
     * @return string
     */
    public static function getTaskDBName()
    {
        return "task";
    }
    public static function getIdDBName()
    {
        return "id";
    }
    public static function getIsDoneDBName()
    {
        return "is_done";
    }

    /**
     * Возвращает путь к изображению
     * @return string <p>Путь к изображению</p>
     */
    public function getImagePath()
    {
        // Название изображения-пустышки
        $noImage = 'img.jpg';
        // Путь к папке с task img
        $path = '/upload/images/task/';
        // Путь к изображению товара
        $pathToProductImage = $path . $this->id .".". $this->image;

        if (file_exists(ROOT."\\..".$pathToProductImage)) {
            // Если изображение для товара существует
            // Возвращаем путь изображения товара
            return MY_SERVER . '/..' .$pathToProductImage;
        }
        // Возвращаем путь изображения-пустышки
        return MY_SERVER . '/..' . $path . $noImage;
    }
}