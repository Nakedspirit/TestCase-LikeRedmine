<!DOCTYPE html>
<html lang="ru">

<head>

	<meta charset="utf-8">

	<title>Title</title>
	<meta name="description" content="">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<meta property="og:image" content="path/to/image.jpg">
	<link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="img/favicon/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-touch-icon-114x114.png">

	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#000">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#000">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#000">

	<style>body { opacity: 1; overflow-x: hidden; } html { background-color: #fff; }</style>

<body>
    <?php
    require_once __DIR__ . "/../vendor/autoload.php";
    ini_set('display_errors',1);
    error_reporting(E_ALL);
    session_start();
    // Подключение файлов системы
    define('ROOT', dirname(__FILE__).'/../app');
    define('MY_SERVER', '/TestCase/app');
    $bc = new TestCase\app\App();
    ?>
	<link rel="stylesheet" href="<?=MY_SERVER?>/css/main.min.css">
	<script src="<?=MY_SERVER?>/js/scripts.min.js"></script>

</body>
</html>

</head><?php

