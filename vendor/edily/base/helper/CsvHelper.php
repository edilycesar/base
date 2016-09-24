<?php
/**
 * Description of CssminHelper.
 *
 * @author edily
 */
class Csv
{
    public static function prepareData($data)
    {
        $data = html_entity_decode($data);
        $data = str_replace(array(",") , ".", $data);
        $data = str_replace(array(";") , ",", $data);
        $data = str_replace(array("\r\n", "\r", "\n", "\t"), '', $data);
        $data = mb_convert_encoding($data, "ISO-8859-1");
        return $data;
    }
    
    public static function prepareDataArr($array)
    {
        $array2 = array();        
        foreach ($array as $key => $data) {
            
            $data = self::prepareData($data);
            array_push($array2, $data);
        }
        return $array2;
    }
    
}
