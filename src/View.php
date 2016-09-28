<?php
namespace Edily\Base;

/**
 * Description of View.
 *
 * @author Edily Cesar Medule - edilycesar@gmail.com - www.jeitodigital.com.br
 */
class View
{
    public $dados;
    public $viewName;
    public $layoutName;
    public $obj;

    public function render($dataRec)
    {
        $dataRec = $this->showIfNotArray($dataRec);

        $this->prepareDataRec($dataRec);
        $this->prepareData();
        $content = $this->layoutName !== false ? $this->prepareLayoutPath() : $this->dados['_content'];

        //Create vars to layout
        foreach ($this->dados as $key => $value) {
            $name = "view_" . $key;
            $$name = $value;
        }

        if (file_exists($content)) {
            require $content;
        }
    }

    public function content($i = 0)
    {
        if (!is_array($this->dados['_content'])) {
            $content = $this->dados['_content'];
        } else {
            $content = $this->dados['_content'][$i];
        }

        //Create vars to content
        foreach ($this->dados as $key => $value) {
            $$key = $value;
        }

        if (file_exists($content)) {
            require $content;
        }
    }

    private function prepareData()
    {
        $this->dados['_content'] = self::prepareContent($this->viewName);
        $this->dados['_register'] = Register::getAll();
    }

    private function prepareDataRec($dataRec)
    {
        $this->viewName = isset($dataRec['view']) ? $dataRec['view'] : 'index';
        $this->dados = isset($dataRec['data']) ? $dataRec['data'] : null;
        $this->layoutName = isset($dataRec['layout']) ? $dataRec['layout'] : 'layout';
    }

    private function prepareLayoutPath()
    {
        return VIEW_PATH.'/layout/'.$this->layoutName.'.phtml';
    }

    private function prepareContent($viewName)
    {
        if (is_null($viewName) || empty($viewName)) {
            return;
        } elseif (!is_array($viewName)) {
            return VIEW_PATH.'/'.$viewName.'.phtml';
        } else {
            $views = array();
            foreach ($viewName as $key => $view) {
                $views[$key] = $this->prepareContent($view);
            }

            return $views;
        }
    }

    private function showIfNotArray($data)
    {
        if (is_array($data) === true) {
            return $data;
        }
        echo $data;
        exit();
    }
}
