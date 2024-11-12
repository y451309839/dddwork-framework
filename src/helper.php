<?php

use Huizi\Dddwork\Internal\Config;


define('BASE_PATH', dirname(__DIR__));

function run_path(string $path = ''): string
{
    static $runPath = '';
    if (!$runPath) {
        $runPath = is_phar() ? dirname(Phar::running(false)) : BASE_PATH;
    }
    return path_combine($runPath, $path);
}

function base_path($path = ''): string
{
    if (false === $path) {
        return run_path();
    }
    return path_combine(BASE_PATH, $path);
}

function app_path(string $path = ''): string
{
    return path_combine(BASE_PATH . DIRECTORY_SEPARATOR . 'app', $path);
}

function public_path(string $path = ''): string
{
    static $publicPath = '';
    if (!$publicPath) {
        $publicPath = \config('app.public_path') ?: run_path('public');
    }
    return path_combine($publicPath, $path);
}

function config_path(string $path = ''): string
{
    return path_combine(BASE_PATH . DIRECTORY_SEPARATOR . 'config', $path);
}

function runtime_path(string $path = ''): string
{
    static $runtimePath = '';
    if (!$runtimePath) {
        $runtimePath = \config('app.runtime_path') ?: run_path('runtime');
    }
    return path_combine($runtimePath, $path);
}

function path_combine(string $front, string $back): string
{
    return $front . ($back ? (DIRECTORY_SEPARATOR . ltrim($back, DIRECTORY_SEPARATOR)) : $back);
}

function config(string $key = null, $default = null)
{
    return Config::get($key, $default);
}

function is_phar(): bool
{
    return class_exists(Phar::class, false) && Phar::running();
}