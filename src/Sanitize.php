<?php

namespace Edily\Base;

/**
 * Description of StringHelper
 *
 * @author Edily Cesar Medule - edilycesar@gmail.com - www.jeitodigital.com.br
 */
class Sanitize
{

    public static function sanitizeArray($array)
    {
        $array2 = array();
        foreach ($array as $key => $value) {
            if (is_string($value)) {
                $array2[$key] = self::sanitizeString($value);
            } else if (is_array($value)) {
                $array2[$key] = self::sanitizeArray($value);
            } else {
                $array2[$key] = $value;
            }
        }
        return $array2;
    }

    public static function sanitizeString($value)
    {
        $value = str_replace('--', '__', $value);
        return addslashes($value);
    }

    public function sanitizeSQLSelect($query)
    {
        $search = [
            'DELETE',
            'INSERT',
            'UPDATE',
            '--'
        ];
        return str_ireplace($search, '', $query);
    }

}
