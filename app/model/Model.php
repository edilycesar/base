<?php
/**
 * Description of Model.
 *
 * @author edily
 */
abstract class Model extends Database
{
    protected $quantPP = 10;
    public $nPaginas = 1;
    public $msgError;
    public $msgOk;
    public $cache = array();

    public function all($table = '', $alias = '', $orderBy = null)
    {
        if (!empty($this->alias) && empty($alias)) {
            $alias = $this->alias;
        }

        if (!empty($this->table) && empty($table)) {
            $table = $this->table;
        }

        $query = "SELECT * FROM {$table} ";
        $query .= !is_null($orderBy) ? " ORDER BY {$orderBy} " : '';

        return $this->select($query, $alias);
    }

    public function find($where = null, $table = null, $alias = null, $limit = null, $order = null, $offset = null)
    {
        $table = isset($this->table)    && !empty($this->table)    ? $this->table    : $table;
        $alias = isset($this->alias)    && !empty($this->alias)    ? $this->alias   : $alias;
        $where = is_null($where) ? '1=1' : $where;

        $query = "SELECT * FROM {$table} WHERE {$where}";
        $query .= !is_null($order) ? " ORDER BY {$order} " : '';
        $query .= !is_null($limit) ? " LIMIT {$limit} " : '';
        $query .= !is_null($offset) ? " OFFSET {$offset} " : '';
//        echo "<br/>" . $query;
        return $this->select($query, $alias);
    }

    public function findRow($where = null, $table = null, $alias = null, $order = null, $offset = null)
    {
        $dados = $this->find($where, $table, $alias, 1, $order, $offset);

        return isset($dados[0]) ? $dados[0] : false;
    }

    /*
     * @return mixed
     */
    public function insert($data, $table = null, $alias = null, $colsPass = null)
    {
        $colsPass = isset($this->colsPass) && !empty($this->colsPass) ? $this->colsPass : $colsPass;
        $table = isset($this->table)    && !empty($this->table)    ? $this->table    : $table;
        $alias = isset($this->alias)    && !empty($this->alias)    ? $this->alias   : $alias;

        $cols = 'created_at, ';
        $values = "'".date('Y-m-d H:s:i')."', ";
        foreach ($data as $key => $value) {
            if (array_search($key, $colsPass) !== false) {
                $cols .= $key.', ';
                $values .= "'".addslashes($value)."', ";
            }
        }
        $query = "INSERT INTO {$table} ({$this->prepareCols($cols)}) VALUES({$this->prepareValues($values)});";
        $this->query($query, $alias);

        return $this->lastInsertId !== 0 ? $this->lastInsertId : false;
    }

    public function update($data, $where, $table = null, $alias = null, $colsPass = null)
    {
        $colsPass = isset($this->colsPass) && !empty($this->colsPass) ? $this->colsPass : $colsPass;
        $table = isset($this->table)    && !empty($this->table)    ? $this->table    : $table;
        $alias = isset($this->alias)    && !empty($this->alias)    ? $this->alias   : $alias;

        $cols = "updated_at = '".date('Y-m-d H:s:i')."', ";
        foreach ($data as $key => $value) {

            /*
             * !is_numeric($key) corrige um bug que estava deixando passar a posição 0 do array
             * isso impede colunas com numero no nome
             */

            if (!is_numeric($key) && array_search($key, $colsPass) !== false) {
                $cols .= $key." = '".addslashes($value)."', ";
            }
        }
        $query = "UPDATE {$table} SET {$this->prepareCols($cols)} WHERE {$where} ";
        $this->query($query, $alias);

        return $this->affectedRows > 0 ? true : false;
    }

    public function delete($where, $table = null, $alias = null)
    {
        $table = isset($this->table) && !empty($this->table) ? $this->table : $table;
        $alias = isset($this->alias) && !empty($this->alias) ? $this->alias : $alias;

        $query = "DELETE FROM {$table} WHERE {$where} ";
        $this->query($query, $alias);

        return $this->affectedRows;
    }

    private function prepareCols($cols)
    {
        $cols = trim($cols);
        $cols = StringUteis::removeLastChar($cols);

        return $cols;
    }

    private function prepareValues($values)
    {
        $values = trim($values);
        $values = StringUteis::removeLastChar($values);

        return $values;
    }

    public function getUsuarioId()
    {
        $usuario = Register::get('usuario');

        return $usuario['id'];
    }

    public function getUsuarioData()
    {
        $usuario = Register::get('usuario');

        return $usuario;
    }

    public function getVar($nome)
    {
        $var = new Variavel();

        return $var->get($nome);
    }

    public function getnPaginas($query)
    {
        $this->quantPP = (int) $this->quantPP;
        $this->quantPP = $this->quantPP === 0 ? 10 : $this->quantPP;

        $this->select($query);

        return $this->nPaginas = ceil($this->numRows / $this->quantPP);
    }
    
    public function count($from, $where)
    {
        $query = "SELECT COUNT(*) AS c FROM {$from} WHERE {$where} ";
        $data = $this->select($query, $this->alias);
        return isset($data[0]['c']) ? $data[0]['c'] : 0;
    }
}
