<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2d894971262b48d65be0c11a4dec0d91
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Prepad\\PyroTestTask\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Prepad\\PyroTestTask\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2d894971262b48d65be0c11a4dec0d91::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2d894971262b48d65be0c11a4dec0d91::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2d894971262b48d65be0c11a4dec0d91::$classMap;

        }, null, ClassLoader::class);
    }
}
