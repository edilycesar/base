<?php
/**
 * Description of DatabaseInterface
 *
 * @author edily
 */
interface DatabaseInterface {
    
    public function query($query, $dbAlias = '');
            
    public function select($query, $dbAlias = '');
    
    public function getQueryHistory($queryKey);
    
    public function getNumRows();
    
    public function getAffectedRows();
}
