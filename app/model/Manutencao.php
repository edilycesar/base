<?php
/**
 * Description of Manutencao.
 *
 * @author edily
 */
class Manutencao extends Model
{
    public function emManutencao()
    {
        //die("Manu: " . $this->getVar("EM_MANUTENCAO"));
        return $this->getVar('EM_MANUTENCAO') == '1' ? true : false;
    }
}
