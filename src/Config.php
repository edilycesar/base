<?php
namespace Edily\Base;

/**
 * Description of Config
 *
 * @author edily
 */
class Config {
    
    private $globalRoot;
    private $publicFolderName;    
    private $appRoot;    
    private $appControllerPath;
    private $appModelPath;
    private $fwRoot;
    private $fwClassPath;
    private $viewPath;
    private $publicRoot;
    private $appControllerNamespace;

    public function write() 
    {
        $_SESSION['edily_config']['config'] = $this;
    }
    
    public static function read() 
    {
        return $_SESSION['edily_config']['config'];
    }
    
    public function getGlobalRoot() 
    {
        return !empty($this->globalRoot) ? $this->globalRoot : __DIR__ . "/../../../" ;
    }
    
    public function getPublicFolderName() 
    {
        $publicFolder = !empty($this->publicFolderName) 
                                ? $this->publicFolderName : "public";
        $publicFolder = "/" . $publicFolder;
        return str_replace("//", "/", $publicFolder);
    }

    public function getAppRoot() 
    {
        if(!empty($this->appRoot)){
            return $this->appRoot;
        }        
        return $this->getGlobalRoot() . "/app";
    }

    public function getAppControllerPath() 
    {
        return !empty($this->appControllerPath) 
            ? $this->appControllerPath 
            : $this->getAppRoot() . '/controller';
    }

    public function getAppModelPath() 
    {
        return !empty($this->appModelPath) 
            ? $this->appModelPath
            : $this->getAppRoot() . '/model';
    }

    public function getFwRoot() 
    {
        return __DIR__ . "/../";
    }

    public function getFwClassPath() 
    {        
        return __DIR__;
    }

    public function getViewPath() 
    {
        return !empty($this->viewPath) 
            ? $this->viewPath
            : $this->getAppRoot() . '/view';
        
    }
    
    public function getPublicRoot() 
    {
        return !empty($this->publicRoot) 
            ? $this->publicRoot 
            : $this->getGlobalRoot() . $this->getPublicFolderName();
    }

    public function getAppControllerNamespace() 
    {
        return !empty($this->appControllerNamespace) 
            ? $this->appControllerNamespace
            : 'App\Controller';
    }
    
    public function setGlobalRoot($globalRoot = "") 
    {
        $this->globalRoot = $globalRoot;
    }
    
    public function setPublicFolderName($publicFolderName = "public") 
    {        
        $this->publicFolderName = $publicFolderName;
    }

    public function setAppRoot($appRoot = "/app") 
    {
        $this->appRoot = $appRoot;
    }

//    public function setPublicRoot($privateRoot) 
//    {
//        $this->privateRoot = $privateRoot;
//    }

    public function setAppControllerPath($appControllerPath) 
    {
        $this->appControllerPath = $appControllerPath;
    }

    public function setAppModelPath($appModelPath) 
    {
        $this->appModelPath = $appModelPath;
    }

    public function setFwRoot($fwRoot) 
    {
        $this->fwRoot = $fwRoot;
    }

    public function setFwClassPath($fwClassPath) 
    {
        $this->fwClassPath = $fwClassPath;
    }

    public function setViewPath($viewPath) 
    {
        $this->viewPath = $viewPath;
    }

    public function setPublicRoot($publicRoot) 
    {
        $this->publicRoot = $publicRoot;
    }
    
}
//
//define('PUBLIC_FOLDER', $privatePath);
//define('APP_ROOT', GL_ROOT . '/app' );
//define('PUBLIC_ROOT', GL_ROOT . PUBLIC_FOLDER );
//define('APP_CONTROLLER_PATH', APP_ROOT . '/controller' );
//define('APP_MODEL_PATH', APP_ROOT . '/model' );
//define('FW_ROOT', GL_ROOT . '/vendor/edily/base/' );
//define('FW_CLASS_PATH', FW_ROOT . '/src/' );
//define('VIEW_PATH', APP_ROOT . '/view' );
//
//define('APP_CONTROLLER_NAMESPACE', 'App\Controller' ); 
