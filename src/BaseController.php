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

    public function getHttpGet($key = '', $default = '')
    {
        if (empty($key)) {
            return $this->route->params;
        }

        $param = isset($this->route->params[$key]) ? $this->route->params[$key] : $default;
        return Sanitize::sanitizeString($param);
    }

    /**
     * Pega requisições do tipo POST
     * @obs: se nenhuma chave for passada será retornado todos os POSTs caso haja.
     * @return mixed.
     */
    public function getHttpPost($key = '')
    {
        if (!isset($_POST) || empty($_POST) && (!isset($_FILES) || empty($_FILES) )) {
            return false;
        }

        $post = isset($_POST) ? $_POST : [];

        $post = Sanitize::sanitizeArray($post);

        if (!empty($key)) {
            return isset($post[$key]) ? $post[$key] : '';
        }

        if (isset($_FILES) && !empty($_FILES)) {
            //$files = Sanitize::sanitizeArray($_FILES);
            $post['http_files'] = $_FILES;
        }

        return $post;
    }

    /**
     * Pega requisições do tipo POST
     * @obs: se nenhuma chave for passada será retornado todos os POSTs caso haja.
     * @return mixed.
     */
    public function getHttpParam($key = '')
    {
        $params = $this->getHttpPost($key);
        if ($params !== false) {
            return $params;
        }
        return $this->getHttpGet($key);
    }

}
