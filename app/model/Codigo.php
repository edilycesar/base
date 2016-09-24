<?php
/**
 * Description of Carro
 *
 * @author edily
 */
class Codigo extends Model 
{
    protected $alias = "bd2";
    protected $table = "codigo";
    protected $colsPass = array('cod', 'carro_id', 'ativo');
    
    public function codigoAtivo($carroId) 
    {
        $codigos = $this->findRow("carro_id = '{$carroId}' AND ativo = '1'");
        return isset($codigos['cod']) ? $codigos['cod'] : false;
    }   
    
    public function disponiveis() 
    {
        return $this->find("carro_id = '0' AND ativo = '0'");
    } 
    
    public function vincular($carroId, $cod) 
    {   
        $this->desativar($carroId);
        
        $dados['carro_id'] = $carroId;
        $dados['ativo'] = 1;
        
        $where = "cod = '{$cod}' "
        . " AND carro_id = 0 "
        . " AND ativo = 0 ";
        
        //die($where);
        
        return $this->update($dados, $where);
    }
    
    public function desativar($carroId) 
    {
        $query = "UPDATE codigo SET ativo = 0 WHERE carro_id = '{$carroId}'";
        return $this->query($query);
    }
    
    public function getCod($carroId) 
    {
        $codigo = $this->findRow("carro_id = '{$carroId}' AND ativo = 1 ");
        return isset($codigo['cod']) ? $codigo['cod'] : false;
    }
    
    public function gerarCodBarras($carroId) 
    {
        $codigo = $this->getCod($carroId);
        $pathBcl = FILES_PATH . "/tmp/" . $codigo . ".png";
        $urlBcl = BASE_URL . "files/tmp/" . $codigo . ".png";
        if(file_exists($pathBcl) === false){
            $bcl = new BarcodeLoko(350, 100, $pathBcl);
            $bcl->gerar_codigo_de_barras($codigo);
        }    
        return $urlBcl;
    }
}
