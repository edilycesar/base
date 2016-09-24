<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Arquivo.
 *
 * @author edily
 */
class Variavel extends Model
{
    protected $table = 'variaveis';
    protected $alias = 'bd1';
    protected $colsPass = array('variavel_valor');

    public function listar()
    {
        return $this->all();
    }

    public function carregar($id)
    {
        $id = (int) $id;
        $dados = $this->find("variavel_id = '{$id}' ");

        return isset($dados[0]) ? $dados[0] : array();
    }

    public function gravar($dados)
    {
        //print_r($dados);
        $where = " variavel_id = '{$dados['variavel_id']}' ";
        $ar = $this->update($dados, $where);
        if ($ar > 0) {
            FlashMsg::setMsgOk('Gravado com sucesso');

            return true;
        } else {
            FlashMsg::setMsgError('Erro ao gravar');

            return false;
        }
    }

    public function get($nome)
    {
        $lista = $this->listar();
        foreach ($lista as $variavel) {
            if ($variavel['variavel_nome'] == $nome) {
                return $variavel['variavel_valor'];
            }
        }

        return;
    }
}
