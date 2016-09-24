<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UteisHelper.
 *
 * @author edily
 */
class Uteis
{
    public function pegaH1($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $string = curl_exec($ch);
        $i = strpos($string, '<h1>');
        $f = strpos($string, '</h1>');
        $len = $f - $i;
        $title = substr($string, $i, $len);

        return strip_tags($title);
    }
}
