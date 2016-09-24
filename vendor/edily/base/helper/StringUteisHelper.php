<?php
/**
 * Description of StringHelper.
 *
 * @author Edily Cesar Medule - edilycesar@gmail.com - www.jeitodigital.com.br
 */
class StringUteis
{
    public static function removeLastChar($string)
    {
        return substr($string, 0, strlen($string) - 1);
    }

    public static function removeVirgulaFinal($string)
    {
        $len = strlen($string);
        if (substr($string, $len - 1, 1) == ',') {
            $string = substr($string, 0, $len - 1);
        }

        return $string;
    }

    public static function removeEmpty($string, $separator = ',')
    {
        $array = ArrayLoko::str2ArrRemoveEmpty($string);

        return implode(',', $array);
    }

    public static function addSlashes($array)
    {
        $array2 = array();
        foreach ($array as $key => $value) {
            if (is_string($value)) {
                $array2[$key] = addslashes($value);
            } else {
                $array2[$key] = $value;
            }
        }

        return $array2;
    }
    
    public static function antiInjection($array)
    {
        $array2 = array();
        foreach ($array as $key => $value) {
            if (is_string($value)) {
                $array2[$key] = addslashes($value);
            } else {
                $array2[$key] = $value;
            }
        }

        return $array2;
    }

    public static function soCarUndPon($string)
    {
        $string = preg_replace("/[^:\/ à-úÀ-Úa-zA-Z0-9_-]/", '', $string);

        return $string;
    }

    public static function removaAcentos($string)
    {
        return preg_replace(array('/(á|à|ã|â|ä)/', '/(Á|À|Ã|Â|Ä)/', '/(é|è|ê|ë)/', '/(É|È|Ê|Ë)/', '/(í|ì|î|ï)/', '/(Í|Ì|Î|Ï)/', '/(ó|ò|õ|ô|ö)/', '/(Ó|Ò|Õ|Ô|Ö)/', '/(ú|ù|û|ü)/', '/(Ú|Ù|Û|Ü)/', '/(ñ)/', '/(Ñ)/', '/(ç)/', '/(Ç)/'), explode(' ', 'a A e E i I o O u U n N c C'), $string);
    }
    
    public static function createAlfaRand($quant = 6, $twoCases = false)
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
}
