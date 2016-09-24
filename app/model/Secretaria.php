<?php
/**
 * Description of Secretaria
 *
 * @author edily
 */
class Secretaria extends Model 
{
    protected $alias = "bd2";
    protected $table = "secretaria";
    protected $colsPass = array('id', 'nome');
    
    public function gravar($dados) 
    {
        $dados['id'] = (int)$dados['id'];
        if($dados['id'] === 0){
            return $this->insert($dados);
        }else{            
            if($this->update($dados, "id = '{$dados['id']}'") === false){
               $dados['id'] = false; 
            }
            return $dados['id'];
        }
    }
    
}