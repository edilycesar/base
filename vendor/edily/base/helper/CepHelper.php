<?php
/**
 * Description of CepHelper.
 *
 * @author edily
 */
class Cep
{
    public function buscar($cep)
    {
        $cep = Number::numbers($cep);
        $url = 'http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&formato=json&cep='.$cep;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($ch);
    }
}
