<?php
/**
 * Description of numberHelper.
 *
 * @author edily
 */
class Number
{
    public function randonNumber($length = 32)
    {
        $rand = '';
        for ($i = 0; $i <= $length; ++$i) {
            $rand .= rand(0, 9);
        }

        return $rand;
    }

    public function moneyBr2Us($value)
    {
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        return $value;
    }

    public function moneyUs2Br($value)
    {
        //$value = str_replace("", "", $value);
        $value = str_replace('.', ',', $value);

        return $value;
    }

    public function numbers($value)
    {
        $num = '';
        $c = strlen($value);
        for ($i = 0; $i <= $c; ++$i) {
            $ch = substr($value, $i, 1);
            if (is_numeric($ch)) {
                $num .= $ch;
            }
        }

        return $num;
    }

    public function doisDigitos($n)
    {
        $n = (int) $n;
        if ($n >= 0 && $n <= 9) {
            return '0'.$n;
        }

        return $n;
    }
}
