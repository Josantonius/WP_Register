<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd5ac133fc09c2e5af61f44fbca9051a6
{
    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'Josantonius\\WP_Register\\' => 24,
            'Josantonius\\File\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Josantonius\\WP_Register\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/WP_Register',
        ),
        'Josantonius\\File\\' => 
        array (
            0 => __DIR__ . '/..' . '/josantonius/file/src/File',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd5ac133fc09c2e5af61f44fbca9051a6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd5ac133fc09c2e5af61f44fbca9051a6::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
