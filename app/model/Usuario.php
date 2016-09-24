<?php
/**
 * Description of Adm.
 *
 * @author edily
 */
class Usuario extends Model
{
    protected $table = 'usuario';
    protected $alias = 'bd1';
    protected $colsPass = array('id', 'usuario', 'senha', 'departamento_id', 
        'email', 'nome', 'secretaria_id', 'super');

    public function gravar($dados)
    {
        $dados['id'] = (int) $dados['id'];
        $dados['senha'] = trim($dados['senha']);
        $dados['usuario'] = trim($dados['usuario']);

        if ((int) $dados['id'] === 0) {
            $dados['id'] = $this->inserir($dados);
            if ($dados['id'] === false) {
                return false;
            }
        } else {
            $this->atualizar($dados);
        }

        $gru = new UsuarioGrupo();

        return $this->affectedRows > 0 &&
                $gru->ingressar($dados['id'], $dados['grupos']) === true
                ? true : false;
    }

    public function usuarioExiste($nome)
    {
        return $this->findRow("usuario = '{$nome}'") !== false ? true : false;
    }

    public function emailExiste($email)
    {
        return $this->findRow("email = '{$nome}'") !== false ? true : false;
    }

    private function inserir($dados)
    {
        if ($this->validaSenha($dados) === false) {
            return false;
        }

        if ($this->usuarioExiste($dados['usuario'])) {
            $this->msgError = 'Usuário já existe';

            return false;
        }

        if ($this->usuarioExiste($dados['email'])) {
            $this->msgError = 'E-mail já existe';

            return false;
        }

        $dados['senha'] = $this->senhaRash($dados['senha']);

        return $this->insert($dados);
    }

    private function atualizar($dados)
    {
        if ( $dados['gravarSenha'] == 1 ) {
            if ($this->validaSenha($dados) === false) {
                return false;
            } else {
                $dados['senha'] = $this->senhaRash($dados['senha']);
            }
        } else {
            //Se a senha estiver em branco a key dos arrays são removidas para evitar a substituição
            unset($this->colsPass['senha']);
            unset($dados['senha']);
        }
        $where = " id = '{$dados['id']}'";

        return $this->update($dados, $where);
    }

    public function senhaRash($senha)
    {
        return md5($senha);
    }

    public function validaSenha($dados)
    {
        if (strlen($dados['senha']) < 5) {
            $this->msgError = 'Senha muito curta';

            return false;
        } elseif ($dados['senha'] != $dados['senha2']) {
            $this->msgError = 'As senhas estão diferentes';

            return false;
        }

        return true;
    }

    public function carregar($id = '', $usuario = '', $senha = '')
    {
        $senhaMd5 = md5($senha);
        $where = '1=1';
        $where .= !empty($id) ? " AND id = '{$id}' " : '';
        $where .= !empty($usuario) ? " AND usuario = '{$usuario}' " : '';
        $where .= !empty($senha) ? " AND senha = '{$senhaMd5}' " : '';

        return empty($where) ? false : $this->findRow($where);
    }

    public function logar($dados)
    {
        $usuario = $this->carregar('', $dados['usuario'], $dados['senha']);
        if ($usuario === false) {
            $this->msgError = 'Login e/ou senha inválido(s)';

            return false;
        } else {
            Register::set('usuario', $usuario);

            return true;
        }
    }

    public function sair()
    {
        Register::set('usuario', null);
    }

    public function listar()
    {
        return $this->find();
    }

    private function emailCadastrado($email)
    {
        $email = trim($email);
        $where = "adm_email = '{$email}' ";
        $dados = $this->find($where);

        return count($dados) > 0 ? true : false;
    }

    public function autenticado()
    {
        $usuario = Register::get('usuario');

        return isset($usuario['usuario']);
    }

    public function listarComGrupos()
    {
        $gru = new UsuarioGrupo();
        $usuarios2 = array();
        foreach ($this->find() as $usuario) {
            $grupos = array();
            $gMembro = $gru->usuGrupos($usuario['id']);
            foreach ($gMembro as $gId) {
                array_push($grupos, $gru->findRow("id='{$gId}'"));
            }
            $usuario['grupos'] = $grupos;
            array_push($usuarios2, $usuario);
        }

        return $usuarios2;
    }

    public function todosIds()
    {
        $ids = '';
        $usuarios = $this->select('SELECT id FROM usuario');
        foreach ($usuarios as $usuario) {
            $ids .= $usuario['id'].',';
        }

        return StringUteis::removeVirgulaFinal($ids);
    }
}
