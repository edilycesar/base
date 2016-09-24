<?php
/**
 * Description of Secretaria
 *
 * @author edily
 */
class Modelo extends Model 
{
    protected $alias = "bd2";
    protected $table = "carro_modelo";
    protected $colsPass = array('id', 'nome');
}
