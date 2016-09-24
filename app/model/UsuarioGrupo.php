<?php
/**
 * Description of Adm.
 *
 * @author edily
 */
class UsuarioGrupo extends Model
{
    protected $table = 'usuario_grupo';
    protected $alias = 'bd1';
    protected $colsPass = array('id', 'nome', 'membros');

    public function carregar($id)
    {
        $where = '';
        $where .= !empty($id) ? " id = '{$id}' " : '';

        return empty($where) ? false : $this->findRow($where);
    }

    public function listar()
    {
        return $this->find();
    }

    public function eMembro($grupoId, $usuarioId)
    {
        //die("EM: $grupoId, $usuarioId ");
        $grupo = $this->findRow("id = '{$grupoId}' ");
        //echo ("GMS {$grupo['membros']} ");
        $membros = explode(',', $grupo['membros']);

        return array_search($usuarioId, $membros) === false ? false : true;
    }

    public function usuGrupos($usuarioId)
    {
        $usuGrupos = array();
        $grupos = $this->find();
        foreach ($grupos as $grupo) {
            if ($this->eMembro($grupo['id'], $usuarioId)) {
                array_push($usuGrupos, $grupo['id']);
            }
        }

        return $usuGrupos;
    }

    public function gravar($dados)
    {
        $dados['id'] = (int) $dados['id'];
        $dados['usuario'] = trim($dados['nome']);
        if ((int) $dados['id'] === 0) {
            return $this->insert($dados);
        } else {
            $where = " id = '{$dados['id']}'";

            return $this->update($dados, $where);
        }
    }

    public function ingressar($usuarioId, $gruposIds = array())
    {
        try {
            foreach ($this->find() as $grupo) {
                if (array_search($grupo['id'], $gruposIds) !== false) {
                    $this->incluirUsuario($usuarioId, $grupo['id']);
                } else {
                    $this->removerUsuario($usuarioId, $grupo['id']);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();

            return false;
        }

        return true;
    }

    public function incluirUsuario($usuarioId, $grupoId)
    {
        $grupo = $this->findRow("id='{$grupoId}'");
        $membros = explode(',', $grupo['membros']);
        if (array_search($usuarioId, $membros) === false) {
            array_push($membros, $usuarioId);
        }
        $grupo['membros'] = implode(',', $membros);

        return $this->update($grupo, "id='{$grupoId}'");
    }

    public function removerUsuario($usuarioId, $grupoId)
    {
        $membros2 = array();
        $grupo = $this->findRow("id='{$grupoId}'");
        $membros = explode(',', $grupo['membros']);
        foreach ($membros as $mId) {
            if ((int) $mId !== (int) $usuarioId) {
                array_push($membros2, $mId);
            }
        }
        $grupo['membros'] = implode(',', $membros2);

        return $this->update($grupo, "id='{$grupoId}'");
    }
}
