<?php
namespace Edily\Base;

/**
 * Description of Controller.
 *
 * @author edily
 */
abstract class BaseController
{
    protected $route;
    public $dados;
    public $headCss;
    public $headJs;

    public function __construct()
    {
        $this->route = \Edily\Base\Register::get('route');
        $this->dados = \Edily\Base\Register::get('dados');
    }

    public function getParam($key, $default = '')
    {        
        return isset($this->route->params[$key]) ? $this->route->params[$key] : $default;
    }    
}
