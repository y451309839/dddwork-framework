<?php

namespace Huizi\Dddwork\Base;

use Phar;

class Path
{

    public static function run(string $path = '') : string
    {
        static $runPath = '';
        if (!$runPath) {
            $runPath = static::isPhar() ? dirname(Phar::running(false)) : BASE_PATH;
        }
        return static::combine($runPath, $path);
    }

    public static function base($path = '') : string
    {
        if (false === $path) {
            return static::run();
        }
        return static::combine(BASE_PATH, $path);
    }

    public static function config($path = '') : string
    {
        return static::combine(BASE_PATH . DIRECTORY_SEPARATOR . 'config', $path);
    }

    public static function runtime($path = '') : string
    {
        return static::combine(BASE_PATH . DIRECTORY_SEPARATOR . 'runtime', $path);
    }

    public static function public($path = '') : string
    {
        return static::combine(BASE_PATH . DIRECTORY_SEPARATOR . 'public', $path);
    }

    public static function app($path = '') : string
    {
        return static::combine(BASE_PATH . DIRECTORY_SEPARATOR . 'app', $path);
    }

    protected static function combine(string $front, string $back) : string
    {
        return $front . ($back ? (DIRECTORY_SEPARATOR . ltrim($back, DIRECTORY_SEPARATOR)) : $back);
    }

    protected static function isPhar(): bool
    {
        return class_exists(Phar::class, false) && Phar::running();
    }
}
