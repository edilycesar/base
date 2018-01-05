<?php
session_start();
require_once '../vendor/autoload.php';

ini_set("display_erros", "on");
ini_set("session.use_only_cookies", 'on');
date_default_timezone_set('America/Sao_Paulo');
define('GL_ROOT', getcwd() . '/..');

$con = new Edily\Base\Config();
$con->setGlobalRoot(GL_ROOT);
$con->write();

require_once '../vendor/edily/base/config.php';
require_once FW_ROOT . '/boot.php';

 
#DATABASE CONFIG (Optional)
  
$database['db1'] = array(
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => '',
    'username'  => '',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
);

define('DB_CONFIG', json_encode($database));

/*
*Edily Base
*/
$router = new Edily\Base\Router();
$loader = new Edily\Base\Loader();
$ret = $loader->run();
$view = new Edily\Base\View();
$view->obj = $loader->obj;//Passa objeto controller instanciado;

$view->render($ret);