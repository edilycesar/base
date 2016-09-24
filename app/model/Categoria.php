<?php
/**
 * Description of Categoria.
 *
 * @author edily
 */
class Categoria extends Model
{
    protected $alias = 'bd1';
    protected $table = 'categoria';
    protected $colsPass = array('titulo', 'descricao', 'destaque');

    public function gravar($dados, $files = '')
    {
        $dados['destaque'] = isset($dados['destaque']) ? $dados['destaque'] : 0;
        $dados = StringUteis::addSlashes($dados);
        $id = (int) $dados['id'];
        if ($id === 0) {
            $id = $this->inserir($dados);
        } else {
            $id = $this->atualizar($dados);
        }

        //Arquivo capa
        if (isset($files['arq']['tmp_name'])) {
            $arq = new Arquivo('categoria', $id);
            $arq->upload($files['arq']['tmp_name'], $files['arq']['name']);
        }

        return $id;
    }

    public function inserir($dados)
    {
        $id = $this->insert($dados);
        if ($id !== false) {
            FlashMsg::setMsgOk('Gravado com sucesso');
        } else {
            FlashMsg::setMsgError('Erro ao gravar');
        }

        return $id;
    }

    public function atualizar($dados)
    {
        if ($this->update($dados, " id = '{$dados['id']}' ")) {
            FlashMsg::setMsgOk('Atualizado com sucesso');
        } else {
            FlashMsg::setMsgError('Erro ao atualizar');
        }

        return $dados['id'];
    }

    public function carregar($id)
    {
        $categorias[0] = $this->findRow("id = '{$id}'");
        $categorias = $this->joinCapa($categorias);
        $categorias = $this->joinImagens($categorias);

        return $categorias[0];
    }

    public function apagar($id)
    {
        if ($this->delete("id = '{$id}'")) {
            FlashMsg::setMsgOk('Apagado com sucesso');
        } else {
            FlashMsg::setMsgError('Erro ao apagar');
        }
    }

    public function listarDestaques()
    {
        $categorias = $this->find("destaque = '1'");
        $categorias = $this->joinCapa($categorias);

        return $categorias;
    }

    public function joinCapa($categorias)
    {
        $categorias2 = array();
        foreach ($categorias as $categoria) {
            $arq = new Arquivo('categoria', $categoria['id']);
            $arquivo = $arq->getFilesOnly();
            $categoria['capa'] = isset($arquivo[0]) ? $arquivo[0] : '';
            array_push($categorias2, $categoria);
        }

        return $categorias2;
    }

    private function joinImagens($categorias)
    {
        $categorias2 = array();
        foreach ($categorias as $categoria) {
            $arq = new Arquivo('categoria', $categoria['id']);
            $categoria['imagens'] = $arq->getFiles();
            array_push($categorias2, $categoria);
        }

        return $categorias2;
    }
}
