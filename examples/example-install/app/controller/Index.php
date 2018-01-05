<?php

namespace App\Controller;

class Index extends \Edily\Base\BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $fooId = $this->getParam('foo-id', 0); //Get url param 
        
        $data['myText'] = "Foo ID: " . $fooId;        
        $data['myList'] = array('1', '2', '3');
        
        return array('view' => 'index/index', 'data' => $data, 'layout' => 'layout1');
    }

}
