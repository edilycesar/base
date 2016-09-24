<?php
/**
 * Description of Log.
 *
 * @author edily
 */
class LogSuper
{
    public function listar()
    {
        $arq2 = array();
        $path = FILES_PATH;
        $dir = dir($path);
        while (($arq = $dir->read()) !== false) {
            if (substr($arq, 0, 3) == 'log') {
                array_push($arq2, $arq);
            }
        }

        return $arq2;
    }
}
