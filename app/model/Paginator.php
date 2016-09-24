<?php
/**
 * Description of Paginador.
 *
 * @author Edily Cesar Medule 
 */
class Paginator extends Model
{
    protected $alias = "";
    
    public $nPP = 50;
    public $nPg = 0;
    public $pgCurrent = 0;
    public $numReg = 0;
    public $regIni = 0;
    public $regEnd = 0;
    public $debugMode = false;
    public $select;
    
    public function __construct($pgCurrent) {
        $this->pgCurrent = $pgCurrent;
    }
    
    public function run($totalRows) 
    {
        $this->numReg = $totalRows;
        $this->nPg = ceil($this->numReg / $this->nPP);
        $this->regIni = $this->pgCurrent * $this->nPP;
        $this->regEnd = $this->regIni + $this->nPP;        
        
        if($this->debugMode === true){
            $this->debug();
        }
    }
    
    public function debug() 
    {
        echo "<br/>nPP: " . $this->nPP;
        echo "<br/>nPg: " . $this->nPg;
        echo "<br/>numRows: " . $this->numReg;
        echo "<br/>pgAtu: " . $this->pgCurrent;
        echo "<br/>regIni: " . $this->regIni;
        echo "<br/>regEnd: " . $this->regEnd;
    }
    
}
