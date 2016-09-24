<?php
namespace Edily\base;


/**
 * Description of router.
 *
 * @author edily
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
        $this->splitRequest($uriAP);
        $this->prepareParams();
    }

    private function getAfterPublic($uri)
    {
        $root = 'sistema/public/'; //URL raiz public sem domínio
        $uriPublicPos = strlen($root) + strpos($uri, $root);

        return substr($uri, $uriPublicPos);
    }

    private function splitRequest($uriAP)
    {
        $this->requestItens = explode('/', $uriAP);
    }

    private function prepareParams()
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
