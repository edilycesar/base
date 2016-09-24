<?php
namespace Edily\Base;

/**
 * Description of Register.
 *
 * @author edily
 */
class Register
{
    public static function set($key, $value)
    {
        $_SESSION['register'][$key] = $value;
    }

    public static function get($key)
    {
        return isset($_SESSION['register'][$key]) ? $_SESSION['register'][$key] : null;
    }

    public static function kill($key)
    {
        $_SESSION['register'][$key] = null;
        unset($_SESSION['register'][$key]);
    }

    public static function getAll()
    {
        return isset($_SESSION['register']) ? $_SESSION['register'] : null;
    }
}
