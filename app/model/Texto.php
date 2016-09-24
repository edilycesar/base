<?php
/**
 * Description of Texto.
 *
 * @author edily
 */
class Texto extends Model
{
    protected $table = 'texto';
    protected $alias = 'bd1';
    public $textoId = 0;
    protected $colsPass = array('texto_id', 'texto_titulo', 'texto_texto', 'texto_ref', 'texto_cat');
    protected $categoria = '';

    public function __construct($categoria = '')
    {
        $this->categoria = $categoria;
    }

    public function gravar($data, $files = null)
    {
        //Grava dados
        if (0 === (int) $data['texto_id']) {
            if ($this->textoId = $this->insert($data)) {
                $this->textoId = $this->lastInsertId;
            }
        } else {
            if ($this->update($data, "texto_id = '{$data['texto_id']}'")) {
                $this->textoId = (int) $data['texto_id'];
            }
        }

        //Grava arquivos
        if (0 !== (int) $this->textoId && !is_null($files)) {
            $this->gravarArquivos($files);
        }

        return (int) $this->textoId;
    }

    public function carregar($textoId = '', $textoRef = '')
    {
        $query = 'SELECT * FROM texto WHERE 1=1 ';
        $query .= !empty($textoId) ? "AND texto_id = '{$textoId}' " : '';
        $query .= !empty($textoRef) ? "AND texto_ref = '{$textoRef}' " : '';
        $query .= 'LIMIT 1';
        $texto = $this->select($query);
        $texto = isset($texto[0]) ? $texto[0] : '';
        $arq = new Arquivo('texto', $texto['texto_id']);
        $texto['arquivos'] = $arq->getFiles();

        return $texto;
    }

    public function gravarArquivos($files)
    {
        foreach ($files['name'] as $key => $name) {
            $tmpName = $files['tmp_name'][$key];
            $this->gravarArquivo($tmpName, $name);
        }

        return true;
    }

    public function gravarArquivo($tmpName, $name)
    {
        $arq = new Arquivo($this->table, $this->textoId);
        $arq->upload($tmpName, $name);
    }

    public function listar($sistema = null, $limit = null, $offset = null, $orderBy = null, $buscar = '')
    {
        $this->quantPP = $limit;
        $query = 'SELECT * FROM texto WHERE 1=1 ';
        $query .= !is_null($sistema) ? "AND texto_sistema = '{$sistema}' " : '';
        $query .= !empty($this->categoria) ? "AND texto_cat = '{$this->categoria}' " : '';
        $query .= !empty($buscar) ? "AND ( texto_titulo LIKE '%{$buscar}%' OR texto_texto LIKE '%{$buscar}%') " : '';
        $this->getnPaginas($query);
        $query  .= !is_null($orderBy) ? " ORDER BY {$orderBy} " : '';
        $query  .= $this->quantPP > 0 ? " LIMIT {$this->quantPP} " : '';
        $query  .= !is_null($offset) ? " OFFSET {$offset} " : '';
        $textos2 = array();
//        echo "<br/><br/>" . $query;
        $textos = $this->select($query);
        foreach ($textos as $texto) {
            $arq = new Arquivo('texto', $texto['texto_id']);
            $arquivos = $arq->getFiles();
            $texto['capa'] = isset($arquivos[0]['arquivo_nome']) ? $arquivos[0]['arquivo_nome'] : '';
            array_push($textos2, $texto);
        }

        return $textos2;
    }

    public function apagar($textoId)
    {
        $textoId = (int) $textoId;
        $texto = $this->carregar($textoId);
        if ($texto['texto_sistema'] == 1) {
            die("Pelo amor de Deus, não pague textos do Sistema!!!! \n Você tá louco???");

            return 0;
        }
        //Arquivos
        $arq = new Arquivo('texto', $textoId);
        if (0 === $arq->apagarFilhos()) {
            FlashMsg::setMsgError('Erro ao apagar', 0);
        }
        $where = "texto_id = {$textoId} ";
        $ar = $this->delete($where);

        return $ar;
    }

    public function addTopo($texto)
    {
        $topo = $this->carregar(null, 'TOPO');

        return $topo['texto_texto'].$texto;
    }
}
