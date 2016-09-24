<?php
session_start();

ini_set("display_erros", "on");

require_once '../vendor/autoload.php';

$t = new App\Controller\Teste();

/*

//require_once '../config/config.php';
//require_once '../vendor/edily/base/config.php';
//require_once FW_ROOT . '/boot.php';

$router = new Edily\base\Router();

$loader = new Loader();

$ret = $loader->run();

$view = new View();
$view->obj = $loader->obj;//Passa objeto controller instanciado;
$view->render($ret);
 * 
 */