<?php
/**
 * Description of Motorista
 *
 * @author edily
 */
class Motorista extends Model 
{
    protected $alias = "bd2";
    protected $table = "motorista";
    protected $colsPass = array('nome', 'telefoneF', 'telefoneC', 'login', 'senha', 'vencCNH', 'vencCNH2', 'ativo');
    
    public function cnhVencida($motoristaId) 
    {
        $motorista = $this->findRow("id = '{$motoristaId}'");        
        $tsVenc = 2592000 + strtotime($motorista['vencCNH2']);
        return time() > $tsVenc ? true : false;
    }
    
    /*
     * Converte formato data antigo para data US
     */
    public function converteVencCnhParaUsData() 
    {        
        $motoristas = $this->find();
        foreach ($motoristas as $motorista) {
            if( strlen($motorista['vencCNH']) === 8 ) {
                $dia = substr($motorista['vencCNH'], 6, 2);  
                $mes = substr($motorista['vencCNH'], 4, 2);  
                $ano = substr($motorista['vencCNH'], 0, 4);  

                $motorista['vencCNH2'] = $ano . "-" . $mes . "-" . $dia . " 00:00:00"; 

                echo "<br/><br/>";
                echo "<br/>" . $motorista['id'];
                echo "<br/>" . $motorista['vencCNH'];
                echo "<br/>" . $motorista['vencCNH2'];

                //print_r($motorista);
                
                $where = "id = '{$motorista['id']}'";
                if( $this->update($motorista, $where) === false ){
                    die("Erro " . $motorista['id']);
                }                
            }    
        }
    }
    
}