<?php
/**
 * Description of Arquivo.
 *
 * @author Edily Cesar Medule - edilycesar@gmail.com - www.jeitodigital.com.br
 */
class Arquivo extends Model
{
    protected $paiTabela;
    protected $paiId;
    protected $dirFiles;
    protected $table = 'arquivo';
    protected $alias = 'bd1';
    protected $colsPass = array('pai_tabela', 'pai_id', 'arquivo_nome', 'titulo',
        'usuario_id', 'texto', 'tipo', );
    protected $usuarioId;
    public $id;

    public function __construct($tabela = null, $paiId = null)
    {
        $this->dirFiles = FILES_PATH;
        $this->paiTabela = $tabela;
        $this->paiId = (int) $paiId;
        $this->usuarioId = $this->getUsuarioId();
    }

    public function upload($arquivoTempNome, $arquivoNome)
    {
        /*
         * Adiciona data e hora no nome do arquivo
         */
        $extensao = ArquivoHelper::detectaExtensao($arquivoNome);
        $arquivoNome = ArquivoHelper::removeExtensao($arquivoNome);
        $arquivoNome .= '_'.date('d-m-y_H_i_s').'.'.$extensao;

        $destino = $this->dirFiles.'/'.$arquivoNome;
        if (file_exists($destino)) {
            FlashMsg::setMsgError('Um arquivo com o mesmo nome já existe no servidor', 2);

            return false;
        } else {
            if (!move_uploaded_file($arquivoTempNome, $destino)) {
                die('Erro ao mover arquivo');
            } else {
                $this->gravar($arquivoNome);
            }

            return true;
        }
    }

    public function gravar($arquivoNome)
    {
        $data['pai_tabela'] = $this->paiTabela;
        $data['pai_id'] = $this->paiId;
        $data['arquivo_nome'] = $arquivoNome;
        $data['usuario_id'] = (int) $this->getUsuarioId();

        $this->id = $this->insert($data);

        if (false === $this->id) {
            die('Erro ao gravar arquivo na base');
        }

        return true;
    }

    public function getFiles($tipo = null, $orderBy = null, $limit = null)
    {
        $query = "SELECT * FROM arquivo WHERE pai_tabela = '{$this->paiTabela}' AND pai_id = '{$this->paiId}' ";
        $query .= !is_null($tipo) ? "AND tipo = '{$tipo}' " : '';
        $query .= !empty($orderBy) ? " ORDER BY {$orderBy} " : '';
        $query .= !empty($limit) ? " LIMIT {$limit} " : '';

        return $this->select($query, $this->alias);
    }

    public function getFilesOnly($arquivoId = null, $tipo = null)
    {
        $arquivos2 = array();
        $query = "SELECT * FROM arquivo WHERE pai_tabela = '{$this->paiTabela}' AND pai_id = '{$this->paiId}' ";
        $query .= !is_null($arquivoId) ? " AND arquivo_id = '{$arquivoId}' " : '';
        $query .= !is_null($tipo) ? "AND tipo = '{$tipo}' " : '';
        $arquivos = $this->select($query, $this->alias);
        foreach ($arquivos as $key => $arquivo) {
            array_push($arquivos2, $arquivo['arquivo_nome']);
        }

        return $arquivos2;
    }

    public function apagar($arquivoId)
    {
        $arquivos = $this->getFilesOnly($arquivoId);
        $this->unlink($arquivos);
        $where = "arquivo_id = '{$arquivoId}' "
        ."AND pai_tabela = '{$this->paiTabela}' "
        ."AND pai_id = '{$this->paiId}' ";
        //$where .= " AND usuario_id = '{$this->getUsuarioId()}' ";
        $ar = $this->delete($where);

        return $ar;
    }

    public function unlink($arquivos = array())
    {
        foreach ($arquivos as $arquivo) {
            $arquivo = FILES_PATH.$arquivo;
            if (file_exists($arquivo) && !unlink($arquivo)) {
                die('Erro ao apagar arquivo');
            }
        }
    }

    public function apagarFilhos($tipo = null)
    {

        //DISCO
        $arquivos = $this->getFilesOnly(null, $tipo);
        if (count($arquivos) === 0) {
            return true;
        }
        $this->unlink($arquivos);
        //BD
        $where = " pai_tabela = '{$this->paiTabela}' 
            AND pai_id = '{$this->paiId}' AND usuario_id = '{$this->getUsuarioId()}' ";
        $where .= !is_null($tipo) ? "AND tipo = '{$tipo}' " : '';

        $ar = $this->delete($where, 'arquivo');

        return $ar;
    }

//    public function setTexto($dados) 
//    {
//        return $this->update($dados, "arquivo_id = '{$dados['id']}' ");
//    }
//    
//    public function setTipo($id, $tipo) 
//    {
//        $data['tipo'] = $tipo;
//        return $this->update($data, "arquivo_id = '{$id}' ");
//    }

    /*
     * Altera qq valor
     */
    public function setDados($dados)
    {
        return $this->update($dados, "arquivo_id = '{$dados['id']}' ");
    }
}
