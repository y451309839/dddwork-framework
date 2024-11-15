<?php

namespace Huizi\Dddwork\Base;

use Phar;

class System
{
    public static $basePath = '';

    public static function setBasePath(string $basePath = '') : void
    {
        static::$basePath = $basePath;
    }
    
    public static function runPath(string $path = '') : string
    {
        static $runPath = '';
        if (!$runPath) {
            $runPath = static::isPhar() ? dirname(Phar::running(false)) : static::$basePath;
        }
        return static::combinePath($runPath, $path);
    }

    public static function basePath($path = '') : string
    {
        if (false === $path) {
            return static::runPath();
        }
        return static::combinePath(static::$basePath, $path);
    }

    public static function configPath($path = '') : string
    {
        return static::combinePath(static::$basePath . DIRECTORY_SEPARATOR . 'config', $path);
    }

    public static function runtimePath($path = '') : string
    {
        return static::combinePath(static::$basePath . DIRECTORY_SEPARATOR . 'runtime', $path);
    }

    public static function publicPath($path = '') : string
    {
        return static::combinePath(static::$basePath . DIRECTORY_SEPARATOR . 'public', $path);
    }

    public static function appPath($path = '') : string
    {
        return static::combinePath(static::$basePath . DIRECTORY_SEPARATOR . 'app', $path);
    }

    protected static function combinePath(string $front, string $back) : string
    {
        return $front . ($back ? (DIRECTORY_SEPARATOR . ltrim($back, DIRECTORY_SEPARATOR)) : $back);
    }

    protected static function isPhar(): bool
    {
        return class_exists(Phar::class, false) && Phar::running();
    }

    public static function cpuCount(): int
    {
        // Windows does not support the number of processes setting.
        if (DIRECTORY_SEPARATOR === '\\') {
            return 1;
        }
        $count = 4;
        if (is_callable('shell_exec')) {
            if (strtolower(PHP_OS) === 'darwin') {
                $count = (int)shell_exec('sysctl -n machdep.cpu.core_count');
            } else {
                $count = (int)shell_exec('nproc');
            }
        }
        return $count > 0 ? $count : 4;
    }
}
