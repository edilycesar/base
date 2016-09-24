<?php
/**
 * Description of Carro
 *
 * @author edily
 */
class Carro extends Model 
{
    protected $alias = "bd2";
    protected $table = "carro";
    protected $colsPass = array('idS', 'idD', 'idF', 'idM', 'kmIni', 'qrcodeArq',
        '_cod', 'placa', 'tag', 'status', 'idCo', 'combustivel', 'cota', 'tipo',
        'passe_livre', 'timestamp', 'renavan', 'anofab', 'anomod', 'chassi', 
        'cor', 'extintor_venc', 'patrimonio', 'ncontrato', 'capacidade', 
        'cilindrada', 'updated_at');
    
    public function getAll(Paginator $pag, $secs = '', $divs = '', $comb = '', 
            $buscarCol = '', $buscar = '', $finalPlaca = '') 
    {
        $select = "SELECT "
                . "car.id AS carroId, "
                . "car.placa AS carroPlaca, "
                . "car.tipo AS carroTipo, "
                . "car.passe_livre AS carroPasseLivre, "
                . "car.cota AS carroCota, "
                . "cod.cod AS carroCod, "
                . "sec.nome AS secretariaNome, "
                . "fab.nome AS fabricanteNome, "
                . "mode.nome AS modeloNome, "
                . "divi.nome AS divisaoNome ";
        
        $from = "  carro AS car "
                . "LEFT JOIN secretaria AS sec ON sec.id = car.idS "
                . "LEFT JOIN divisao AS divi ON divi.id = car.idD "
                . "LEFT JOIN carro_fabricante AS fab ON fab.id = car.idF "
                . "LEFT JOIN carro_modelo AS mode ON mode.id = car.idM "
                . "LEFT JOIN codigo AS cod ON cod.carro_id = car.id "
                ;
        
        $where = " 1=1 ";
        $where .= !empty($secs) ? " AND idS IN({$secs}) " : "";
        $where .= !empty($divs) ? " AND idD IN({$divs}) " : "";
        $where .= !empty($comb) ? " AND combustivel = '{$comb}' " : "";        
        $where .= !empty($buscarCol) ? " AND {$buscarCol} LIKE '%{$buscar}%' " : "";
        $where .= !empty($finalPlaca) ? " AND placa LIKE '%{$finalPlaca}' " : "";
        
        $pag->run($this->count($from, $where));
        
        $options = " LIMIT {$pag->nPP} OFFSET {$pag->regIni} ";
        
        $query = $select . " FROM " . $from .  " WHERE " . $where . $options;
        
//        echo $query;
        
        return $this->select($query);
    }
    
    public function joinAbLitrosMesAtual($carros) 
    {
        $aba = new Abastecimento();
        $carros2 = array();
        foreach ($carros as $carro) {
            $carro['carroAbMesAtual'] = $aba->ltMesAtual($carro['carroId']); 
            array_push($carros2, $carro);
        }
        return $carros2;
    }
    
    public function joinCodigoAtivo($carros) 
    {
        $cod = new Codigo();
        $carros2 = array();
        foreach ($carros as $carro) {
            $carro['carroCodigo'] = $cod->codigoAtivo($carro['carroId']);
            array_push($carros2, $carro);
        }
        return $carros2;
    }
    
    public function prepareToCSV($carros) 
    {
        $carros2 = array();
        foreach ($carros as $carro) {  
            $carro = Csv::prepareDataArr($carro);
            array_push($carros2, $carro);
        }
        return $carros2;
    }
    
    public function joinMediaKmLitro($carros) {
        $aba = new Abastecimento();
        $carros2 = array();
        foreach ($carros as $carro) {
            $carro['carroAbMediaKmLt'] = $aba->ltMesAtual($carro['carroId']); 
            array_push($carros2, $carro);
        }
        return $carros2;
    }
    
    public function gravar($dados) 
    {        
        if(0 === (int)$dados['id']){
            $dados['id'] = $this->insert($dados);            
        }else{
            $where = " id = '{$dados['id']}' ";
            if($this->update($dados, $where) === false){
                $dados['id'] = false;
            }
        }
        
        if($dados['id'] === false){
            $this->msgError = "Erro ao gravar";
            return false;
        }
        
        //Vincular a novo código
        if( !empty($dados['cod']) ){
            $cod = new Codigo();
            if($cod->vincular($dados['id'], $dados['cod']) === false){
                $this->msgError = "Erro ao vincular código, tente mais uma vez por favor";
                echo $this->msgError;
                return false;
            }
        }
        
        return $dados['id'];
    }
    
    public function findBySec($id, $idS = '') 
    {
        $where = " id = '{$id}' ";
        $where .= !empty($idS) ? " AND idS = '{$idS}' " : "";
        return $this->findRow($where);
    }
}