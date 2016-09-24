<?php
/**
 * Description of CorHelper.
 *
 * @author Edily Cesar Medule 
 */
class Cor
{
    public function rand()
    {
        $hexa = array(10 => 'A', 11 => 'B', 12 => 'C', 13 => 'D', 14 => 'E', 15 => 'F');
        $cod = '#';
        for ($i = 0; $i <= 5; ++$i) {
            $n = rand(0, 15);
            $cod .= $n < 10 ? $n : $hexa[$n];
        }

        return $cod;
    }
}
