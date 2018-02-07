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


class BaseController
{
    public function __construct()
    {
        echo "загружен";
    }
}