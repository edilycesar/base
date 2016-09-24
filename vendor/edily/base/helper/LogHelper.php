<?php
/**
 * Description of LogHelper.
 *
 * @author edily
 */
class Log
{
    public static function gravar($msg)
    {
        $msg = 'IP: '.$_SERVER['REMOTE_ADDR'].' - '.date('d-m-Y H:i:s', time()).' - '.' '.$msg;
        $msg = "<p>{$msg}</p>";
        $path = LOG_PATH.self::getNomeArq();
        $f = fopen($path, 'a');
        fwrite($f, $msg);
        fclose($f);
    }

    public static function getNomeArq()
    {
        return 'log-'.date('Y-m').'.html';
    }
}
