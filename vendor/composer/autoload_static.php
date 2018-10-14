<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita78ecd1e501f5f7d3653e6a1bb9a9d18
{
    public static $prefixLengthsPsr4 = array (
        'Q' => 
        array (
            'QL\\Ext\\Lib\\' => 11,
            'QL\\Ext\\' => 7,
            'QL\\' => 3,
        ),
        'M' => 
        array (
            'Medoo\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'QL\\Ext\\Lib\\' => 
        array (
            0 => __DIR__ . '/..' . '/jaeger/http',
        ),
        'QL\\Ext\\' => 
        array (
            0 => __DIR__ . '/..' . '/jaeger/querylist-ext-aquery',
            1 => __DIR__ . '/..' . '/jaeger/querylist-ext-dimage',
        ),
        'QL\\' => 
        array (
            0 => __DIR__ . '/..' . '/jaeger/querylist',
        ),
        'Medoo\\' => 
        array (
            0 => __DIR__ . '/..' . '/catfan/medoo/src',
        ),
    );

    public static $classMap = array (
        'Callback' => __DIR__ . '/..' . '/jaeger/phpquery-single/phpQuery.php',
        'CallbackBody' => __DIR__ . '/..' . '/jaeger/phpquery-single/phpQuery.php',
        'CallbackParam' => __DIR__ . '/..' . '/jaeger/phpquery-single/phpQuery.php',
        'CallbackParameterToReference' => __DIR__ . '/..' . '/jaeger/phpquery-single/phpQuery.php',
        'CallbackReturnReference' => __DIR__ . '/..' . '/jaeger/phpquery-single/phpQuery.php',
        'CallbackReturnValue' => __DIR__ . '/..' . '/jaeger/phpquery-single/phpQuery.php',
        'DOMDocumentWrapper' => __DIR__ . '/..' . '/jaeger/phpquery-single/phpQuery.php',
        'DOMEvent' => __DIR__ . '/..' . '/jaeger/phpquery-single/phpQuery.php',
        'ICallbackNamed' => __DIR__ . '/..' . '/jaeger/phpquery-single/phpQuery.php',
        'phpQuery' => __DIR__ . '/..' . '/jaeger/phpquery-single/phpQuery.php',
        'phpQueryEvents' => __DIR__ . '/..' . '/jaeger/phpquery-single/phpQuery.php',
        'phpQueryObject' => __DIR__ . '/..' . '/jaeger/phpquery-single/phpQuery.php',
        'phpQueryPlugins' => __DIR__ . '/..' . '/jaeger/phpquery-single/phpQuery.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita78ecd1e501f5f7d3653e6a1bb9a9d18::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita78ecd1e501f5f7d3653e6a1bb9a9d18::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita78ecd1e501f5f7d3653e6a1bb9a9d18::$classMap;

        }, null, ClassLoader::class);
    }
}