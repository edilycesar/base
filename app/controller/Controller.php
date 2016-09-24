<?php
namespace App\Controller;

/**
 * Description of Controller.
 *
 * @author Edily Cesar Medule - edilycesar@gmail.com - www.jeitodigital.com.br
 * 
 * O objeto Controller (e quem herdá-lo) estará instanciado no atributo obj da view 
 * e consequentemente disponível para a camada view.  
 */

abstract class Controller extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function permissao()
    {
        return new Permissao();
    }

    public function getVar($nome)
    {
        $var = new Variavel();

        return $var->getVar($nome);
    }

    public function getTextos($cat)
    {
        $tex = new Texto($cat);

        return $tex->listar();
    }

    public function getUsuarioData($coluna)
    {
        return $this->getUserData($coluna);
    }

    public function getUserData($coluna)
    {
        $usu = new Usuario();
        $usuario = $usu->getUsuarioData();

        return isset($usuario[$coluna]) ? $usuario[$coluna] : null;
    }

    public function getControllersPermitidos()
    {
        $per = new Permissao();

        return $per->gruposPermitidos();
    }
}
