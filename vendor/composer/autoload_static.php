<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd6b3e2bab7c0ea4ece448679e78791c1
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitd6b3e2bab7c0ea4ece448679e78791c1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd6b3e2bab7c0ea4ece448679e78791c1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd6b3e2bab7c0ea4ece448679e78791c1::$classMap;

        }, null, ClassLoader::class);
    }
}
