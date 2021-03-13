<?php

namespace Edily\Base;

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
        $controllerName = ucfirst($this->route->controller) . '';
        $controllerFile = APP_CONTROLLER_PATH . '/' . $controllerName . '.php';
        if (!file_exists($controllerFile)) {
            die('Controller não encontrado: ' . $controllerFile);
        } else {

            $actionName = $this->route->action . 'Action';
            $intercept = $this->interceptExists($controllerName, $this->route->action);
            if ($intercept !== false) {
                $this->instantiate($controllerFile, $intercept['class'], $intercept['method']);
            }

            return $this->instantiate($controllerFile, $controllerName, $actionName);
        }

        return false;
    }

    public function run()
    {
        return $this->loadControllerAction();
    }

    private function instantiate($controllerFile, $controllerName, $actionName)
    {
        $controllerName = "\\" . APP_CONTROLLER_NAMESPACE . "\\" . $controllerName;

        $this->obj = new $controllerName();

        if (!method_exists($this->obj, $actionName)) {
            die('Action não encontrada: ' . $actionName);
        }



        return $this->obj->$actionName();
    }

}
