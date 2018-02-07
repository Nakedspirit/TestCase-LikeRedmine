<?php

/**
 * Маршрутизация
 *
 * @package TestCase
 * @author  Galina Kozyreva <kozyreva.galinka@gmail.com>
 */

return array(
    // Админпанель:
    'admin' => 'AdminView',
    // Главная страница
    'create' => 'site/create',
    // Сортировка:
    'id/page-([0-9]+)' => 'site/index/id/$1', // actionIndex в SiteController
    'username/page-([0-9]+)' => 'site/index/username/$1', // actionIndex в SiteController
    'email/page-([0-9]+)' => 'site/index/email/$1', // actionIndex в SiteController
//    '(^[a-zA-Z_]{1,}$)/' => 'site/index/$1', // actionIndex в SiteController
    'page-([0-9]+)' => 'site/index/id/$1', // actionIndex в SiteController
    'edittext/([0-9]+)' => 'site/editText/$1', // actionIndex в SiteController
    'is_done/([0-9]+)' => 'site/isDone/$1', // actionIndex в SiteController
    'index.php' => 'site/index', // actionIndex в SiteController
    '' => 'site/index' // actionIndex в SiteController
);
