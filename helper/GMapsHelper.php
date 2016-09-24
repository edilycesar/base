<?php
/**
 * Description of GMaps.
 *
 * @author Edily Cesar Medule 
 */
class GMaps
{
    private static function distanciaFazUrl($origemRua, $origemCid, $origemUf, $destinoRua, $destinoCid, $destinoUf)
    {
        $url = 'http://maps.googleapis.com/maps/api/distancematrix/xml?origins='
                .$origemRua.'+'.$origemCid.'+'.$origemUf.'+Brazil&destinations='
                .$destinoRua.'+'.$destinoCid.'+'.$destinoUf.'+Brazil&language=pt-BR&sensor=false';

        return str_replace(' ', '+', $url);
    }

    private static function geocodeFazUrl($dados)
    {
        foreach ($dados as $key => $value) {
            $$key = $value;
        }
        $url = "https://maps.googleapis.com/maps/api/geocode/{$formato}?"
        ."address={$num}+{$rua},+{$cid},+{$uf}&key={$apiKey}";

        return str_replace(' ', '+', $url);
    }

    public static function getGeocode($rua, $num, $cid, $uf, $apiKey, $pais = 'Brazil', $formato = 'xml')
    {
        $dados = array('rua' => $rua, 'num' => $num, 'cid' => $cid, 'uf' => $uf,
            'apiKey' => $apiKey, 'pais' => $pais, 'formato' => $formato, );
        $url = self::geocodeFazUrl($dados);
        $xml = simplexml_load_file($url);

        if ($xml->status != 'OK') {
            Log::gravar('Erro ao converter end em coordenadas: '.$url.' - Status: '.$xml->status);

            return false;
        }

        return array('lat' => $xml->result->geometry->location->lat,
                     'lng' => $xml->result->geometry->location->lng,
                     'end' => $xml->result->formatted_address, );
    }
}
