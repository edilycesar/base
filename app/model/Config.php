<?php
/**
 * Description of Config.
 *
 * @author edily
 */
class Config extends Model
{
    public function gravar($dados)
    {
        Register::set('bdHost', $dados['bdHost']);
        Register::set('bdNome', $dados['bdNome']);
        Register::set('bdSenha', $dados['bdSenha']);
        Register::set('bdUsuario', $dados['bdUsuario']);

        return true;
    }

    public function carregar()
    {
        $dados['bdHost'] = Register::get('bdHost');
        $dados['bdNome'] = Register::get('bdNome');
        $dados['bdSenha'] = Register::get('bdSenha');
        $dados['bdUsuario'] = Register::get('bdUsuario');

        return $dados;
    }
}
