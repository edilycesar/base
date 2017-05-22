# Readme - base_1.0.0

--------------------------------------------------------------------------------

## Structure dir

/app/controller
/app/model
/app/view
/app/intercepts.php (middleware)

/public
/public/index.php
/public/.htaccess

/composer.json

--------------------------------------------------------------------------------

## "composer.json" minnimal example
> {
>   "require": {
>        "edily/base": "dev-master"
>    },
>    
>    "autoload": {	
>        "psr-4": {
>            "App\\Model\\": "app//model",
>            "App\\Controller\\": "app//controller"
>        }
>    }
>}


### Important! 
#Execute the command: "composer dump-autoload" to make changes in only in autoload.
#Execute the command: "composer update" to make any changes in composer.json.

--------------------------------------------------------------------------------

##.htaccess minnimal example
>#Apache configuration file (see httpd.apache.org/docs/2.2/mod/quickreference.html)
>RewriteEngine On
>RewriteRule ^$ index.php [QSA]
>RewriteCond %{REQUEST_FILENAME} !-d
>RewriteCond %{REQUEST_FILENAME} !-f
>RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]

>#disable directory listing
>Options -Indexes

--------------------------------------------------------------------------------

## /public/index.php example
><?php
>session_start();
>require_once '../vendor/autoload.php';
>
>ini_set("display_erros", "on");
>ini_set("session.use_only_cookies", 'on');
>date_default_timezone_set('America/Sao_Paulo');
>define('GL_ROOT', getcwd() . '/..');
>
>$con = new Edily\Base\Config();
>$con->setGlobalRoot(GL_ROOT);
>$con->write();
>
>require_once '../vendor/edily/base/config.php';
>require_once FW_ROOT . '/boot.php';
>
> 
>#DATABASE CONFIG (Optional)
>  
>$database['db1'] = array(
>    'driver'    => 'mysql',
>    'host'      => 'localhost',
>    'database'  => '',
>    'username'  => '',
>    'password'  => '',
>    'charset'   => 'utf8',
>    'collation' => 'utf8_unicode_ci',
>    'prefix'    => '',
>);

>define('DB_CONFIG', json_encode($database));

>/*
>*Edily Base
>*/
>$router = new Edily\Base\Router();
>$loader = new Edily\Base\Loader();
>$ret = $loader->run();
>$view = new Edily\Base\View();
>$view->obj = $loader->obj;//Passa objeto controller instanciado;

>$view->render($ret);

--------------------------------------------------------------------------------

## Controller example (/app/controller/Index.php)
><?php
>namespace App\Controller;
>
>class Index extends \Edily\Base\BaseController {
>    
>    public function indexAction() 
>    {
>        echo "Hello World in Controller";
>
>        $data['foo'] = "Hello World in View";
>
>        return array("view"=>"emissor/list", "data"=>$data, "layout"=>"site");
>
>    }
>}

-------------------------------------------------------------------------------

## View example (/view/index/index.phtml)

><?php echo $foo ?>

-------------------------------------------------------------------------------

## Interceps (/app/intercepts.php (middleware))

ex:

><?php
>/*
> *  Controller@Action => Controller/Model@method
> * 
> *  ex1: "UsuarioController@carregar" => "Autenticar@autenticar",
> *  ex2: "*@*" => "Permissao@permitir"
> *  * = coringa
> *
> */
>
>return array(
> 'Index@new' => 'Auth@loginAction',
> 'User@write' => 'User@isLogged'
>);

