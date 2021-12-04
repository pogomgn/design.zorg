<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3c0d3c4c55459f9a4e7f5523c78940b5
{
    public static $files = array (
        '9e4824c5afbdc1482b6025ce3d4dfde8' => __DIR__ . '/..' . '/league/csv/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'controller\\' => 11,
            'classes\\' => 8,
            'claire\\' => 7,
        ),
        'L' => 
        array (
            'League\\Csv\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'controller\\' => 
        array (
            0 => __DIR__ . '/..' . '/controller',
        ),
        'classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
        'claire\\' => 
        array (
            0 => __DIR__ . '/..' . '/claire',
        ),
        'League\\Csv\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/csv/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3c0d3c4c55459f9a4e7f5523c78940b5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3c0d3c4c55459f9a4e7f5523c78940b5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3c0d3c4c55459f9a4e7f5523c78940b5::$classMap;

        }, null, ClassLoader::class);
    }
}
