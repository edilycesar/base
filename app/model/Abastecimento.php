<?php
/**
 * Description of Abastecimento
 *
 * @author edily
 */
class Abastecimento extends Model
{    
    protected $alias = "bd2";
    protected $table = "abastecimento";
    protected $colsPass = array('idM', 'idC', 'data', 'timestamp', 'km', 'lt', 'idCo', 'host', 'valor');
    
    public function getAll(Paginator $pag, $secs = '', $buscarCol = ''
            , $buscar = '', $combs = '', $dataDe = '', $dataAte = '') 
    {
        $select = " SELECT *,"
                . " car.id AS carId, "
                . " aba.timestamp AS abaMomento, "
                . " aba.id AS abaId, "
                . " aba.lt AS abaLt, "
                . " sec.nome AS secNome, "
                . " hos.nome AS hostNome, "
                . " mot.id AS motId,"
                . " mot.nome AS motNome,"
                . " mode.nome AS modNome,"
                . " fab.nome AS fabNome,"
                . " car.tipo AS carTipo,"
                . " com.nome AS comNome,"
                . " com.valor AS comValor ";
        
        $from = " abastecimento AS aba "
                . " LEFT JOIN carro AS car ON car.id = aba.idC "
                . " LEFT JOIN secretaria AS sec ON sec.id = car.idS"
                . " LEFT JOIN host AS hos ON hos.id = aba.host"
                . " LEFT JOIN motorista AS mot ON mot.id = aba.idM "
                . " LEFT JOIN carro_modelo AS mode ON mode.id = car.idM "
                . " LEFT JOIN carro_fabricante AS fab ON fab.id = mode.idF "
                . " LEFT JOIN combustivel AS com ON com.id = aba.idCo ";
        
        $where = " 1=1 ";
        $where .= !empty($secs) ? " AND car.idS IN({$secs}) " : "";
        $where .= !empty($combs) ? " AND aba.idCo IN({$combs}) " : "";
        $where .= !empty($buscarCol) ? " AND {$buscarCol} LIKE '%{$buscar}%' " : "";
        $where .= !empty($finalPlaca) ? " AND placa LIKE '%{$finalPlaca}' " : "";        
        
        $where .= !empty($dataDe) ? " AND aba.timestamp >= '{$dataDe}' " : "";        
        $where .= !empty($dataAte) ? " AND aba.timestamp <= '{$dataAte}' " : "";        
        
        //echo $where;
        
        $pag->run( $this->count($from, $where) );
        
        $options = " LIMIT {$pag->nPP} OFFSET {$pag->regIni} ";
        
        $query = $select . " FROM " . $from .  " WHERE " . $where . $options;
        
//        echo $query;
        
        return $this->select($query);
    }
    
    public function joinLastKm($abastecimentos)
    {
        $abastecimentos2 = array();
        foreach ($abastecimentos as $abastecimento) {
            $abastecimento['abUltimoKm'] = $this->ultimaKilometragem($abastecimento['carId']);
            array_push($abastecimentos2, $abastecimento);
        }
        return $abastecimentos2;
    }

    public function joinCostData($abastecimentos)
    {        
        $abastecimentos2 = array();
        foreach ($abastecimentos as $abastecimento) {            
            $abastecimento['abaValorTot'] = $abastecimento['comValor'] * $abastecimento['abaLt'];
            array_push($abastecimentos2, $abastecimento);
        }
        return $abastecimentos2;
    }
    
    public function joinAlerts($abastecimentos)
    {        
        $mot = new Motorista();
        
        $abastecimentos2 = array();
        foreach ($abastecimentos as $abastecimento) {            
            
            $al = $mot->cnhVencida($abastecimento['motId']) === true 
                  ? " CNH Vencida ou data não informada " : "";
                    
            $abastecimento['alertas'] = $al;
            array_push($abastecimentos2, $abastecimento);
        }
        return $abastecimentos2;
    }

    /*
     * Pega litros abastecidos 
     * @param $carroId int
     * @return double
     */
    public function ltMesAtual($carroId = '') 
    {
        $datas = $this->iniFimMesAtual();
        $query = "SELECT SUM(lt) AS tot FROM abastecimento WHERE 1=1 ";
        $query .= "AND timestamp >= '{$datas['ini']}' ";
        $query .= "AND timestamp <= '{$datas['fim']}' ";
        $query .= !empty($carroId) ? "AND idC = '{$carroId}' " : "";        
        $dados = $this->select($query); 
        return (double)isset($dados[0]['tot']) ? $dados[0]['tot'] : 0;     
    }
    
    /*
     * Pega do banco/cache data inicio e fim do mes atual e armazena em cache caso não haja
     * @return array
     */    
    public function iniFimMesAtual() 
    {   
        if (!empty($this->cache['iniMesAtual']) && !empty($this->cache['fimMesAtual']) ) {
            $datas['ini'] = $this->cache['iniMesAtual']; 
            $datas['fim'] = $this->cache['fimMesAtual'];             
        } else {    
            $datas = Date::iniFimMesAtual();
            $this->cache['iniMesAtual'] = $datas['ini']; 
            $this->cache['fimMesAtual'] = $datas['fim'];            
        }
        return $datas;
    }
    
    public function ltTotal($carroId) 
    {
        $query = "SELECT SUM(lt) AS tot FROM abastecimento 
                WHERE idC = '{$carroId}'";          
        $dados = $this->select($query);
        return (double)isset($dados[0]['tot']) ? $dados[0]['tot'] : 0;     
    }
    
    public function ultimaKilometragem($carroId) 
    {
        $query = "SELECT km FROM abastecimento WHERE idC = '{$carroId}' ORDER BY id DESC LIMIT 1";
        $dados = $this->select($query);
        return isset($dados[0]['km']) ? $dados[0]['km'] : 0;
    }
    
    public function primeiraKilometragem($carroId) 
    {        
        $query = "SELECT km FROM abastecimento WHERE idC = '{$carroId}' ORDER BY id ASC LIMIT 1";
        $dados = $this->select($query);
        return isset($dados[0]['km']) ? $dados[0]['km'] : 0;
    }
    
    public function KlRodados($carroId) 
    { 
        return $this->ultimaKilometragem($carroId) - $this->primeiraKilometragem($carroId);
    }
    
    public function mediaKmLitro($carroId)
    {       
        $ltTot = $this->ltTotal($carroId);
        if($ltTot > 0){
            $lt = $this->KlRodados() / $ltTot;
            return number_format($lt, 2, ".", "");
        }
        return 0;             
    }
}