<?php
/**
 * Description of DateHelper.
 *
 * @author Edily Cesar Medule - edilycesar@gmail.com - www.jeitodigital.com.br
 */
class ArrayLoko
{
    public function removeEmpty($array)
    {
        $array2 = array();
        foreach ($array as $value) {
            $value = trim($value);
            if (!empty($value)) {
                array_push($array2, $value);
            }
        }

        return $array2;
    }

    public function str2ArrRemoveEmpty($string)
    {
        $array = explode(',', $string);

        return self::removeEmpty($array);
    }
}
