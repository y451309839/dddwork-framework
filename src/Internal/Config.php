<?php

namespace Huizi\Dddwork\Internal;

use FilesystemIterator;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class Config
{

    protected static $config = [];

    protected static $configPath = '';

    protected static $loaded = false;

    public static function load(string $configPath, array $exclude = [])
    {
        static::$configPath = $configPath;
        if ($configPath == '') {
            return;
        }
        $config = static::loadFromDir($configPath, $exclude);
        static::$loaded = true;
        if (empty($config)) {
            return;
        }
        static::$config = array_replace_recursive(static::$config, $config);
    }

    public static function clear()
    {
        static::$config = [];
    }

    public static function loadFromDir(string $configPath, array $exclude = [])
    {
        $allConfig = [];
        $dirIterator = new RecursiveDirectoryIterator($configPath, FilesystemIterator::FOLLOW_SYMLINKS);
        $iterator = new RecursiveIteratorIterator($dirIterator);
        foreach ($iterator as $file) {
            if (is_dir($file) || $file->getExtension() != 'php' || in_array($file->getBaseName('.php'), $exclude)) {
                continue;
            }
            $relativePath = str_replace($configPath . DIRECTORY_SEPARATOR, '', substr($file, 0, -4));
            $explode = array_reverse(explode(DIRECTORY_SEPARATOR, $relativePath));
            $config = include $file;
            foreach ($explode as $section) {
                $tmp = [];
                $tmp[$section] = $config;
                $config = $tmp;
            }
            $allConfig = array_replace_recursive($allConfig, $config);
        }
        return $allConfig;
    }

    public static function get(string $key = null, string $default = null)
    {
        if (!static::$loaded) {
            return $default;
        }
        if ($key === null) {
            return static::$config;
        }
        $value = static::$config;
        $keyArray = explode('.', $key);
        foreach ($keyArray as $index) {
            if (!isset($value[$index])) {
                return $default;
            }
            $value = $value[$index];
        }
        return $value;
    }
}
