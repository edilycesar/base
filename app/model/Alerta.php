<?php
/**
 * Description of Alerta.
 *
 * @author Edily Cesar Medule 
 */
class Alerta extends Model
{
    protected $table = 'alerta';
    protected $alias = 'bd1';
    protected $colsPass = array('usuario_id', 'data', 'msg', 'visto', 'md5');

    public function add($msg, $usuarioId = 0)
    {
        $data['md5'] = md5($msg);
        $msg = addslashes($msg);
        $data['msg'] = $msg;
        $data['usuario_id'] = $usuarioId;
        $data['data'] = date('Y-m-d H:i:s');
        $data['visto'] = 0;

        $where = "usuario_id = '{$usuarioId}' AND md5 = '{$data['md5']}'";

        $alerta = $this->findRow($where);
        if ($alerta !== false) {
            return $this->update($data, "id = '{$alerta['id']}'");
        }

        return $this->insert($data);
    }

    public function addVarios($msg, $usuariosIds)
    {
        $usuarios = explode(',', $usuariosIds);
        foreach ($usuarios as $usuariosId) {
            $this->add($msg, $usuariosId);
        }
    }
}
