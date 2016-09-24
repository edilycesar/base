<?php
/**
 * Description of Permissao.
 *
 * @author edily
 */
class Permissao extends Model
{
    protected $usuarioId;
    protected $table = 'permissao';
    protected $alias = 'bd1';
    protected $colsPass = array('id', 'grupo_id', 'usuario_id', 'tipo');

    public function __construct()
    {
        $this->usuarioId = $this->getUsuarioId();
    }

    public function permitido($grupo_nome)
    {
        if (!$this->usuarioPermitido($grupo_nome)) {
            Log::gravar("Tentou acessar um recurso nao permitido ({$grupo_nome}).");
            if (null === $this->getUsuarioId()) {
                Redirect::to('usuario/autenticar');
                exit();
            }
            die('Você (ID'.$this->getUsuarioId().") não tem permissão para acessar esse recurso ({$grupo_nome}).");
        }
    }

    public function permitidoBoolean($grupo_nome)
    {
        $usuario_id = (int) $_SESSION['codigousuario'];
        if (!$this->usuarioPermitido($grupo_nome, $usuario_id)) {
            return false;
        }

        return true;
    }

    public function usuarioPermitido($grupo_nome)
    {
        //Usuário permitido
        $this->usuarioId = (int) $this->usuarioId;

        if ($this->usuarioId === 0) {
            return false;
        }

        $query = "SELECT per.id FROM permissao AS per 
            INNER JOIN permissao_grupo AS gru ON per.grupo_id = gru.id                        
            WHERE per.tipo = 'usuario' ";
        $query .= " AND  per.usuario_id = '{$this->usuarioId}'";
        $query .= " AND  gru.nome = '{$grupo_nome}'";
        $query .= ' LIMIT 1';
        //echo ($query);        
        $this->select($query);
        if ($this->numRows > 0) {
            return  true;
        }

        //Se usuário pertence a grupo permitido
        $query = "SELECT per.id, per.usuario_id FROM permissao AS per 
            INNER JOIN permissao_grupo AS gru ON per.grupo_id = gru.id                        
            WHERE per.tipo = 'grupo' ";
        $query .= " AND  gru.nome = '{$grupo_nome}'";

        $uGru = new UsuarioGrupo();
        $permissoes = $this->select($query);
        foreach ($permissoes as $permissao) {
            $grupoId = isset($permissao['usuario_id']) ? $permissao['usuario_id'] : null;
            if ($uGru->eMembro($grupoId, $this->getUsuarioId())) {
                return true;
            }
        }

        return false;
    }

    public function pegaPermissao($grupoNome = null, $usuarioId = null, $permissaoId = null)
    {
        $query = 'SELECT * FROM permissao AS per 
            INNER JOIN permissao_grupo AS gru ON per.grupo_id = gru.id            
            WHERE 1=1 ';
        $query .= $usuarioId !== null ? " AND  per.usuario_id = {$usuarioId} " : '';
        $query .= $grupoNome !== null ? " AND  gru.nome = {$grupoNome} " : '';
        $query .= $permissaoId !== null ? " AND  per.id = {$permissaoId} " : '';
        $query .= ' LIMIT 1';
        //echo $query;
        return $this->select($query, $this->alias);
    }

    public function pegaPermissao0($grupoNome = null, $usuarioId = null, $permissaoId = null)
    {
        $query = 'SELECT * FROM permissao AS per 
            INNER JOIN permissao_grupo AS gru ON per.grupo_id = gru.id                        
            WHERE 1=1 ';
        $query .= $usuarioId !== null ? " AND  per.usuario_id = {$usuarioId} " : '';
        $query .= $grupoNome !== null ? " AND  gru.nome = {$grupoNome} " : '';
        $query .= $permissaoId !== null ? " AND  per.id = {$permissaoId} " : '';
        $query .= ' LIMIT 1';
        //echo $query;
        return $this->select($query, $this->alias);
    }

    public function listar($grupoId = null)
    {
        $usu = new Usuario();
        $gru = new UsuarioGrupo();
        $query = 'SELECT *, per.id AS permissao_id FROM permissao AS per 
            INNER JOIN permissao_grupo AS gru ON per.grupo_id = gru.id            
            WHERE 1=1 ';
        $query .= $grupoId !== null ? " AND gru.id = '{$grupoId}' " : ' ';
        $query .= ' ORDER BY gru.nome ';
        $permisaoLista = $this->select($query, $this->alias);
        $permisaoListaNova = array();
        foreach ($permisaoLista as $permissao) {
            if ($permissao['tipo'] == 'usuario') {
                $permissao['usuario'] = $usu->carregar($permissao['usuario_id']);
            } else {
                $permissao['usuario'] = $gru->carregar($permissao['usuario_id']);
            }
            array_push($permisaoListaNova, $permissao);
        }

        return $permisaoListaNova;
    }

    public function gravar($recursos, $usuariosIds, $tipos)
    {
        foreach ($recursos as $key => $recurso) {
            $idsArr = explode(',', $usuariosIds[$key]);
            $tiposArr = explode(',', $tipos[$key]);
            foreach ($idsArr as $key2 => $usuarioId) {
                if (!empty($usuarioId)) {
                    $this->inserirUnico($recurso, $usuarioId, $tiposArr[$key2]);
                }
            }
        }
    }

    public function inserirUnico($recurso, $usuarioId, $tipo)
    {
        $grupoId = $this->pegaGrupoId($recurso);
        if ($this->existe($grupoId, $usuarioId) === false) {
            //Log::gravar("G: " . $grupoId . " U: " . $usuarioId . " T: " . $tipo);
            $this->inserir($grupoId, $usuarioId, $tipo);
        }
    }

    public function inserir($grupoId, $usuarioId, $tipo)
    {
        //Reg::gravar("O usuário ID " . $usuarioId . " foi inserido no grupo ID " . $grupoId);
        $query = "INSERT INTO permissao (grupo_id, usuario_id, tipo) VALUES('{$grupoId}', '{$usuarioId}', '{$tipo}')";
        $this->query($query, $this->alias);
        $this->registrarEvento('Permissao inserida: Grupo: '.$grupoId.' Usuário: '.$usuarioId);
    }

    public function existe($grupoId, $usuarioId)
    {
        $query = "SELECT id FROM permissao WHERE grupo_id = '{$grupoId}' AND usuario_id = '{$usuarioId}' LIMIT 1";
        $this->query($query, $this->alias);

        return $this->numRows > 0 ? true : false;
    }

    public function apagar($permissaoId)
    {
        $permissao = $this->pegaPermissao(null, null, $permissaoId);
        $permissao = $permissao[0];
        //Reg::gravar("Apagou permissao - Grupo " . $permissao['nome'] . " Usuário "  . $permissao['cod_usuario']);
        $query = "DELETE FROM permissao WHERE id = '{$permissaoId}' LIMIT 1";
        $this->query($query, $this->alias);
        $this->registrarEvento('Permissao apagada: '.$permissaoId);
    }

    public function insereTodosUsuarios($recurso)
    {
        $usuariosIds = '';
        $usu = new Usuario();
        $usuLista = $usu->listarAdmin();
        foreach ($usuLista as $dados) {
            $usuariosIds .= $dados['cod_usuario'].',';
        }
        $recursos = array($recurso);
        $usuariosIdsArr = array($usuariosIds);
        $this->gravar($recursos, $usuariosIdsArr);
    }

    public function pegaGrupoId($nome)
    {
        $query = 'SELECT id FROM permissao_grupo '
                ."WHERE nome = '{$nome}' "
                ."AND ativo = '1' LIMIT 1";
        $dados = $this->select($query, $this->alias);

        return isset($dados[0]['id']) ? (int) $dados[0]['id'] : false;
    }

    public function grupoListar()
    {
        $grupoListaNova = array();
        $grupoLista = $this->all('permissao_grupo', $this->alias, 'descricao ASC');
        foreach ($grupoLista as $gkey => $grupo) {
            if ($grupo['ativo'] == 1) {
                $grupo['membrosLista'] = $this->listar($grupo['id']);
                array_push($grupoListaNova, $grupo);
            }
        }

        return $grupoListaNova;
    }

//    public function permitir() 
//    {
//        $route = Register::get('route');
//        $recursoNome = ucfirst($route->controller . "_" . $route->action);
//        //die($recursoNome);
//        $grupoId = $this->pegaGrupoId($recursoNome);
//        if($grupoId !== false){
//            $this->permitido($recursoNome);
//        }
//    }

    public function permitir()
    {
        $route = Register::get('route');
        $recursoNome = ucfirst($route->controller.'_'.$route->action);
        //die($recursoNome);
        $grupoId = $this->pegaGrupoId($recursoNome);
        if ($grupoId !== false) {
            $this->permitido($recursoNome);
        }
    }

    public function gruposPermitidos()
    {
        $grupos = '';
        $grupoLista = $this->all('permissao_grupo', $this->alias, 'descricao ASC');
        foreach ($grupoLista as $gkey => $grupo) {
            if ($grupo['ativo'] == 1) {
                if ($this->usuarioPermitido($grupo['nome']) !== false) {
                    $grupos .= $grupo['nome'].',';
                }
            }
        }

        return $grupos;
    }
}
