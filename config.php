<?php

$con = Edily\Base\Config::read();

define('PUBLIC_FOLDER', $con->getPublicFolderName());
define('APP_ROOT', $con->getAppRoot());
define('PUBLIC_ROOT', $con->getPublicRoot());
define('APP_CONTROLLER_PATH', $con->getAppControllerPath() );
define('APP_MODEL_PATH', $con->getAppModelPath());
define('FW_ROOT', $con->getFwRoot());
define('FW_CLASS_PATH', $con->getFwClassPath() );
define('VIEW_PATH', $con->getViewPath());
define('APP_CONTROLLER_NAMESPACE', $con->getAppControllerNamespace()); 

//$publicPath = '/public';
//define('PUBLIC_FOLDER', $publicPath);
//define('APP_ROOT', GL_ROOT . '/app' );
//define('PUBLIC_ROOT', GL_ROOT . PUBLIC_FOLDER );
//define('APP_CONTROLLER_PATH', APP_ROOT . '/controller' );
//define('APP_MODEL_PATH', APP_ROOT . '/model' );
//define('FW_ROOT', GL_ROOT . '/vendor/edily/base/' );
//define('FW_CLASS_PATH', FW_ROOT . '/src/' );
//define('VIEW_PATH', APP_ROOT . '/view' );
//define('APP_CONTROLLER_NAMESPACE', 'App\Controller' ); 

echo "<br/>PUBLIC_FOLDER " . PUBLIC_FOLDER;
echo "<br/>APP_ROOT " . APP_ROOT;
echo "<br/>PUBLIC_ROOT " . PUBLIC_ROOT;
echo "<br/>APP_CONTROLLER_PATH " . APP_CONTROLLER_PATH;
echo "<br/>APP_MODEL_PATH " . APP_MODEL_PATH;
echo "<br/>FW_ROOT " . FW_ROOT;
echo "<br/>FW_CLASS_PATH " . FW_CLASS_PATH;
echo "<br/>VIEW_PATH " . VIEW_PATH;
echo "<br/>APP_CONTROLLER_NAMESPACE " . APP_CONTROLLER_NAMESPACE;