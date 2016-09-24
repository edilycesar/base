<?php

function createAlfaRand($quant = 6, $twoCases = false)
    {
        $string = '';
        $array = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
                    'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'x', 'y', 'z', '0', '1',
                    '2', '3', '4', '5', '6', '7', '8', '9');
        $c = count($array) - 1;
        for ($i = 0; $i <= $quant; ++$i) {
            $n = rand(0, $c);
            
            if($twoCases === true && !is_numeric($n)){                
                $n = rand(0, 1) == 0 ? strtolower($n) : strtoupper($n);
            }
            
            $string .= $array[$n];
        }

        return $string;
    }
$txt = "";

for($i=0; $i<=20; $i++){
    $senha = createAlfaRand();
    $rash = md5($senha);
    $txt .= $senha . ";" . $rash . "\n";
}

file_put_contents("./files/banana.csv", $txt);
