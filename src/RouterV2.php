<?php
namespace Edily\base;

/**
 * Description of router.
 *
 * @author Edily Cesar Medule edilycesar@gmail.com
 */
class Router
{
    protected $requestItens;
    public $controller, $action, $params;

    public function __construct()
    {
        $this->prepareUri();
        $this->getController();
        $this->getAction();

    //echo "<br/>Controller: " . $this->controller;
    //echo "<br/>Action: " . $this->action;

        Register::set('route', $this);
    }

    private function getRequestUrI()
    {
        return $_SERVER['REQUEST_URI'];
    }

    private function getController()
    {
        $this->controller = !empty($this->requestItens[0]) ? $this->requestItens[0] : 'Index';
    }

    private function getAction()
    {
        $this->action = isset($this->requestItens[1]) ? $this->requestItens[1] : 'index';
    }

    private function prepareUri()
    {
        $uri = $this->getRequestUrI();
        $uriAP = $this->getAfterPublic($uri);
    //echo "<br/>URI AP: " . $uriAP;
        $this->splitRequest($uriAP);
        if (PUBLIC_FOLDER == '/') {
            $this->prepareParamsControllerEven();
        } else {
            $this->prepareParamsControllerOdd();
        }
    }

    private function getAfterPublic($uri)
    {
        //echo "<br/>URI: " . $uri;
    //echo "<br/>PF: " . PUBLIC_FOLDER;
    $len = strlen(PUBLIC_FOLDER);
    //echo "<br/>LEN: " . $len;
        $uriPublicPos = $len + strpos($uri, PUBLIC_FOLDER);

        return substr($uri, $uriPublicPos);
    }

    private function splitRequest($uriAP)
    {
        $this->requestItens = explode('/', $uriAP);
    }

    private function prepareParamsControllerEven()
    {
        $var = $val = '';
        foreach ($this->requestItens as $key => $value) {
            if ($key > 1) {
                if (($key % 2) == 0) {
                    $var = $value;
                } else {
                    $val = $value;
                }
                $this->params[$var] = $val;
            }
        }
    }

    private function prepareParamsControllerOdd()
    {
        $var = $val = '';
        foreach ($this->requestItens as $key => $value) {
            if ($key > 1) {
                if (($key % 2) == 0) {
                    $var = $value;
                } else {
                    $val = $value;
                }
                $this->params[$var] = $val;
            }
        }
    }
}
