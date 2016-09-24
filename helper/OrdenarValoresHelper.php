<?php
/**
 * Description of OrdenarValoresHelper.
 *
 * @author edily
 */
class OrdenarValores
{
    public function ordena($dataArr, $invert = false)
    {
        $arrayOrdenado = array();
        while (count($dataArr) > 0) {
            $maior = $this->pegaMaior($dataArr);
            //echo "<br/>Maior: " . $maior;
            array_push($arrayOrdenado, $maior);
            $dataArr = $this->tiraValor($dataArr, $maior);
        }

        return $invert === false ? $arrayOrdenado : $this->inverter($arrayOrdenado);
    }

    private function pegaMaior($dataArr)
    {
        $maior = 0;
        foreach ($dataArr as $value) {
            $maior = $this->daUmMaior($maior, $dataArr);
        }

        return $maior;
    }

    private function tiraValor($dataArr, $valorTirar)
    {
        $array2 = array();
        foreach ($dataArr as $value) {
            if ($value != $valorTirar) {
                array_push($array2, $value);
            }
        }

        return $array2;
    }

    private function daUmMaior($maior, $array)
    {
        foreach ($array as $valor) {
            $valor = (int) $valor;
            if ($valor > $maior) {
                return $valor;
            }
        }

        return $maior;
    }

    private function inverter($array)
    {
        return array_reverse($array);
    }
}
