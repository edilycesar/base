<?php
namespace App\Controller;

/**
 * Description of IndexController.
 *
 * @author edily
 */
class IndexController extends Controller
{
    public function indexAction()
    {
        $dados = array();
        return array('view' => 'index/index', 'dados' => $dados, 'layout' => 'site');
    }
}
