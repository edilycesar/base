<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DateHelper.
 *
 * @author Edily Cesar Medule - edilycesar@gmail.com - www.jeitodigital.com.br
 */
class Date
{
    public static function toBr($date, $showHour = true)
    {
        if (empty($date)) {
            return;
        }

        // 2015-11-04 09:00:56
        $y = substr($date, 0, 4);
        $m = substr($date, 5, 2);
        $d = substr($date, 8, 2);
        $h = substr($date, 11, 2);
        $i = substr($date, 14, 2);
        $s = substr($date, 17, 2);
        $hour = $h.':'.$i.':'.$s;
        $date = $d.'-'.$m.'-'.$y;
        $date .= $showHour === true ? ' '.$hour : '';

        return $date;
    }

    public static function toUs($date, $exibeHora = true)
    {
        // 30-06-2015
        $date = trim($date);
        if (strlen($date) < 9) {
            //die("Data erro: " . $date);
            return '00-00-00 00:00:00';
        }
        $date = str_replace('/', '-', $date);
        if (strpos($date, ' ')) {
            $dH = explode(' ', $date);
        } else {
            $dH[0] = $date;
            $dH[1] = '00:00:00';
        }
        $dateArr = explode('-', $dH[0]);
        $hourArr = isset($dH[1]) ? explode(':', $dH[1]) : array();
        $y = self::zeroEsquerdo($dateArr[2]);
        $m = self::zeroEsquerdo($dateArr[1]);
        $d = self::zeroEsquerdo($dateArr[0]);
        $h = self::zeroEsquerdo($hourArr[0]);
        $i = self::zeroEsquerdo($hourArr[1]);
        $s = self::zeroEsquerdo($hourArr[2]);
        $date = $y.'-'.$m.'-'.$d;
        $date .= $exibeHora === true ? ' '.$h.':'.$i.':'.$s : '';

        return $date;
    }

    public static function zeroEsquerdo($n)
    {
        $n = (int) $n;
        if ($n < 10) {
            $n = '0'.$n;
        }

        return $n;
    }

    public static function day()
    {
        return date('d');
    }

    public static function month()
    {
        return date('m');
    }

    public static function monthTxBr()
    {
        $meses = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
        $m = date('m');

        return $meses[$m];
    }

    public static function year()
    {
        return date('Y');
    }

    public static function getYear($date)
    {
        return substr($date, 0, 4);
    }

    public static function getMonth($date)
    {
        return substr($date, 5, 2);
    }

    public static function getDay($date)
    {
        return substr($date, 8, 2);
    }

    public static function getHourMin($date)
    {
        return substr($date, 11, 5);
    }

    public static function getHour($date)
    {
        return substr($date, 11, 2);
    }

    public static function getMin($date)
    {
        return substr($date, 14, 2);
    }

    public static function getDate($date)
    {
        return substr($date, 0, 10);
    }

    public static function diaNExisteRetAnt($date)
    {
        $year = self::getYear($date);
        $month = self::getMonth($date);
        $day = self::getDay($date);
        while (checkdate($month, $day, $year) === false) {
            //echo " D" . $day . " M" . $month .  " Y" . $year;
            $day = (int) $day;
            --$day;
            $day = ''.$day;
        }

        return $day;
    }

    public static function diaNExisteRetProx($date)
    {
        echo '<br/>Entrada: '.$date;
        $year = self::getYear($date);
        $month = self::getMonth($date);
        $day = self::getDay($date);

        echo '<br/>Process: '.$year.'-'.$month.'-'.$day;

        if (checkdate($month, $day, $year) === false) {

//            die("inválida");

            $month = self::avancaMes($month);
            $year = $month != '1' ? $year : $year + 1;
            $date = $year.'-'.$month.'-01';
        }
        echo '<br/>....Saida: '.$date;

        return $date;
    }

    public static function avancaMes($mes)
    {
        $mes = (int) $mes;
        $mes = $mes == 12 ? 1 : $mes + 1;

        return self::zeroEsquerdo($mes);
    }

    public static function primeiroTsMes($mes, $ano)
    {
        $mes = self::zeroEsquerdo($mes);
        $date = $ano.'-'.$mes.'-01 01:00:00'; //a 1 hora por causa do horário de verão
        return strtotime($date);
    }
    
    public static function primeiroUltimoDiaMes($mes, $ano) 
    {
        $mesAtu = self::zeroEsquerdo($mes);
        $dataIni = $ano.'-'.$mesAtu.'-01 00:00:00'; //a 1 hora por causa do horário de verão
        
    }
    
    public static function ultimoDiaMes($mes, $ano) 
    {
        $mes = self::zeroEsquerdo($mes);
        for($i = 28; $i<=32; $i++){
            $dia = self::zeroEsquerdo($i);
            $data = $ano . "-" . $mes . "-" . $dia;            
            if (checkdate($mes, $dia + 1, $ano) === false){
                return $data;
            }
        }
    }
    
    public static function iniFimMesAtual() 
    {
        $mesAtu = date('m');
        $anoAtu = date('Y');
        
        $dados['ini'] = $anoAtu . '-' . $mesAtu . '-01 00:00:00';
        $dados['fim'] = self::ultimoDiaMes($mesAtu, $anoAtu) . ' 23:59:59';
        
        return $dados;
    }
}
