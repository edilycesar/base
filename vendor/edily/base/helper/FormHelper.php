<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormHelper.
 *
 * @author Edily Cesar Medule - edilycesar@gmail.com - www.jeitodigital.com.br
 */
class Form
{
    public function tryOrNull($value)
    {
        return isset($value) ? $value : null;
    }
}
