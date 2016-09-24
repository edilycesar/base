<?php
/**
 * Description of CssminHelper.
 *
 * @author edily
 */
class Cssmin
{
    public static function make($buffer)
    {
        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
        $buffer = str_replace(': ', ':', $buffer);

        return str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    }
}
