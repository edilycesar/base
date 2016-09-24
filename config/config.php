<?php
/*
 * GLOBAL CONFIG
 */
ini_set('display_errors', 'on');
ini_set("session.use_only_cookies", 'on');

//header('Cache-Control: max-age=0');
//header('Access-Control-Allow-Origin: *');

date_default_timezone_set('America/Sao_Paulo');
define('GL_ROOT', getcwd() . '/..');

/*
 * APP CONFIG
 */
define('DOMINIO', 'http://edilycam.ddns.net:8080');
define('BASE_URL', DOMINIO . '/edily/combustivel_2.0/www/public/');
define('ORGANIZACAO_NOME', '');
define('FILES_PATH', GL_ROOT . "/public/files/");
define('FILES_URL', BASE_URL . "/files/");
define('IMGS_PATH', BASE_URL . "/files/");
define('LOG_PATH', FILES_PATH);
define('HASH', "2d64G4f52Y");
define('EMAIL_MASTER', 'contato@forje.com.br');

//DATABASE CONFIG
$hosts     = array('bd1' => 'localhost',        'bd2' => 'localhost');
$names     = array('bd1' => 'combustivel_sis',  'bd2' => 'combustivel');
$users     = array('bd1' => 'root',             'bd2' => 'root');
$passwords = array('bd1' => 'sss',              'bd2' => 'sss');

define('DB_HOST', json_encode($hosts));
define('DB_NAME', json_encode($names));
define('DB_USER', json_encode($users));
define('DB_PASS', json_encode($passwords));

//E-MAIL CONFIG
//GMail
//define('MAIL_SMTPSECURE', 'ssl');
//define('MAIL_HOST', 'smtp.gmail.com');
//define('MAIL_PORT', '465');
//define('MAIL_USERNAME', 'edilycesar@gmail.com');
//define('MAIL_PASSWORD', '');

define('MAIL_SMTPSECURE', '');
define('MAIL_HOST', '');
define('MAIL_PORT', '');
define('MAIL_USERNAME', '');
define('MAIL_PASSWORD', '');

//Pagseguro
define('PAGSEGURO_EMAIL', '');
define('PAGSEGURO_TOKEN', '');