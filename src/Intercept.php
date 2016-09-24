<?php
namespace Edily\Base;

/**
 * Description of Intercept.
 *
 * @author edily
 */
class Intercept
{
    public function getItencepts()
    {
        $filename = APP_ROOT.'/intercepts.php';
        $array = require $filename;

        return $array;
    }

    protected function interceptExists($controller, $action)
    {
        $inteceptRules = $this->getItencepts();
        foreach ($inteceptRules as $inteceptController => $inteceptModel) {
            $intercepts = $this->splitClassMethod($inteceptController);

//            Estável
//            if($intercepts['class'] == $controller && $intercepts['method'] == $action){
//                return $this->splitClassMethod($inteceptModel);
//            }

            //Teste
            if (($intercepts['class'] == $controller || $intercepts['class'] == '*') &&
                ($intercepts['method'] == $action || $intercepts['method'] == '*')) {
                return $this->splitClassMethod($inteceptModel);
            }
        }

        return false;
    }

    protected function splitClassMethod($controllerAction)
    {
        $array = explode('@', $controllerAction);
        $array2['class'] = $array[0];
        $array2['method'] = $array[1];

        return $array2;
    }
}
