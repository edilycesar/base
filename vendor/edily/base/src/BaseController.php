<?php
namespace Edily\base;

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
        $this->route = Register::get('route');
        $this->dados = Register::get('dados');
    }

    public function getParam($key, $default = '')
    {
        echo "blah";
        return isset($this->route->params[$key]) ? $this->route->params[$key] : $default;
    }

    public function headAddCss($file)
    {
        $filename = PUBLIC_ROOT.'/'.$file;
        if (!file_exists($filename)) {
            die('Arquivo não encontrado: '.$filename);
        }
        $css = file_get_contents($filename);
        $css = Cssmin::make($css);
        $this->headCss .= $css;
    }

    public function headAddJsFile($file)
    {
        $filename = PUBLIC_ROOT.'/'.$file;
        if (!file_exists($filename)) {
            die('Arquivo não encontrado: '.$filename);
        }
        $script = file_get_contents($filename);
        $this->headAddJsScript($script);
    }

    public function headAddJsScript($script)
    {
        $jsq = new JSqueeze();
        $this->headJs .= $jsq->squeeze($script, true, false);
        //$this->headJs .= $script; //debug
    }

    public function headGetCss()
    {
        return "<style>{$this->headCss}</style>";
    }

    public function headGetJs()
    {
        return  "<script type='text/javascript'>{$this->headJs}</script>";
    }
}
