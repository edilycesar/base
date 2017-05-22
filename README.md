# base_1.0.0

--------------------------------------------------------------------------------

[Structure dir]

/app/controller
/app/model
/app/view
/app/intercepts.php (middleware)

/public
/public/index.php
/public/.htaccess

/composer.json

--------------------------------------------------------------------------------

[composer.json minnimal example]
{
   "require": {
        "edily/base": "dev-master"
    },
    
    "autoload": {	
        "psr-4": {
            "App\\Model\\": "app//model",
            "App\\Controller\\": "app//controller"
        }
    }
}

--------------------------------------------------------------------------------

[.htaccess minnimal example]
# Apache configuration file (see httpd.apache.org/docs/2.2/mod/quickreference.html)
RewriteEngine On
RewriteRule ^$ index.php [QSA]
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php/$1 [QSA,L]

# disable directory listing
Options -Indexes

--------------------------------------------------------------------------------

[/public/index.php example]
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

 /*
  * DATABASE CONFIG (Optional)
  */
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

--------------------------------------------------------------------------------

[Controller example (/app/controller/Index.php)]
<?php
namespace App\Controller;

class Index extends \Edily\Base\BaseController {
    
    public function indexAction() 
    {
        echo "Helo World";
    }
}

-------------------------------------------------------------------------------

[Interceps (/app/intercepts.php (middleware))]

<?php
/*
 *  Controller@Action => Controller/Model@method
 * 
 *  ex1: "UsuarioController@carregar" => "Autenticar@autenticar",
 *  ex2: "*@*" => "Permissao@permitir"
 *  * = coringa
 *
 */
ex:
return array(
 'Index@new' => 'Auth@loginAction',
 'User@write' => 'User@isLogged'
);

