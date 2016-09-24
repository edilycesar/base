<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit13f3688a76b18c26ea143970b3c20ea9
{
    public static $files = array (
        'e88992873b7765f9b5710cab95ba5dd7' => __DIR__ . '/..' . '/hoa/consistency/Prelude.php',
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
        ),
        'L' => 
        array (
            'League\\Csv\\' => 11,
        ),
        'H' => 
        array (
            'Hoa\\Zformat\\' => 12,
            'Hoa\\View\\' => 9,
            'Hoa\\Router\\' => 11,
            'Hoa\\Exception\\' => 14,
            'Hoa\\Event\\' => 10,
            'Hoa\\Dispatcher\\' => 15,
            'Hoa\\Consistency\\' => 16,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
        'A' => 
        array (
            'Aura\\View\\_Config\\' => 18,
            'Aura\\View\\' => 10,
            'App\\Model\\' => 10,
            'App\\Controller\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'League\\Csv\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/csv/src',
        ),
        'Hoa\\Zformat\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/zformat',
        ),
        'Hoa\\View\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/view',
        ),
        'Hoa\\Router\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/router',
        ),
        'Hoa\\Exception\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/exception',
        ),
        'Hoa\\Event\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/event',
        ),
        'Hoa\\Dispatcher\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/dispatcher',
        ),
        'Hoa\\Consistency\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/consistency',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
        'Aura\\View\\_Config\\' => 
        array (
            0 => __DIR__ . '/..' . '/aura/view/config',
        ),
        'Aura\\View\\' => 
        array (
            0 => __DIR__ . '/..' . '/aura/view/src',
        ),
        'App\\Model\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/model',
        ),
        'App\\Controller\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/controller',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit13f3688a76b18c26ea143970b3c20ea9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit13f3688a76b18c26ea143970b3c20ea9::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
