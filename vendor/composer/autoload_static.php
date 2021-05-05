<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfe20f7d391bac13880b06f6dcda6cd6c
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfe20f7d391bac13880b06f6dcda6cd6c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfe20f7d391bac13880b06f6dcda6cd6c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfe20f7d391bac13880b06f6dcda6cd6c::$classMap;

        }, null, ClassLoader::class);
    }
}