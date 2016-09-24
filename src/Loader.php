<?php
namespace Edily\Base;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Loader.
 *
 * @author edily
 */
class Loader extends Intercept
{
    protected $route;
    public $obj;

    public function __construct()
    {
        $this->route = Register::get('route');
    }

    public function loadControllerAction()
    {
        $controllerName = ucfirst($this->route->controller).'Controller';
        $controllerFile = APP_CONTROLLER_PATH.'/'.$controllerName.'.php';
        if (!file_exists($controllerFile)) {
            die('Controller não encontrado: '.$controllerFile);
        } else {
            $actionName = $this->route->action.'Action';
            $intercept = $this->interceptExists($controllerName, $this->route->action);
            if ($intercept !== false) {
                $this->instantiate($intercept['class'], $intercept['method']);
            }

            return $this->instantiate($controllerName, $actionName);
        }

        return false;
    }

    public function run()
    {
        return $this->loadControllerAction();
    }

    private function instantiate($controllerName, $actionName)
    {
        $this->obj = new $controllerName();
        if (!method_exists($this->obj, $actionName)) {
            die('Action não encontrada: '.$actionName);
        } else {
            return $this->obj->$actionName();
        }
    }
}
