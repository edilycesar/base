<?php
/**
 * Description of AlertasHelper.
 *
 * @author edily
 */
class QRcode
{
    public function gerar($url, $filename)
    {
        //FORMATO PNG
        $url = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl={$url}%2F&choe=UTF-8";
        $header = array('Content-Type: image/png');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $rec = curl_exec($ch);

        $f = fopen($filename, 'w');
        fwrite($f, $rec);
        fclose($f);

        if (file_exists($filename)) {
            return true;
        }

        return false;
    }
}
