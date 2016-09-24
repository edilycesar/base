<?php
/**
 * Description of Adm.
 *
 * @author edily
 */
class UsuarioJd extends Model
{
    protected $table = 'usuarios_site';
    protected $alias = 'bd1';
    protected $colsPass = array('id', 'nome', 'login', 'senha');

//    public function migrar() 
//    {
//        $usu = new Usuario();
//        
//        $usuarios = $this->find();
//        foreach ($usuarios as $usuario) {
//            echo "<br/>" . $usuario['login'] . " - " . $usuario['nome'] . " - " . $usuario['senha'];
//            
//            $dados['id'] = $usuario['id'];
//            $dados['email'] = $usuario['login']; 	
//            $dados['nome'] = $usuario['nome']; 	
//            $dados['senha'] = $usu->senhaRash(trim($usuario['senha'])); 	
//            $dados['usuario'] = $usuario['login'];
//            
//            $usu->insert($dados);
//        }
//    }
}
