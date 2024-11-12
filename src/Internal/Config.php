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

    public static function load($configPath, $exclude = [])
    {

    }

    public static function loadFromDir($configPath, $exclude = [])
    {
        $allConfig = [];
        $dirIterator = new RecursiveDirectoryIterator($configPath, FilesystemIterator::FOLLOW_SYMLINKS);
        $iterator = new RecursiveIteratorIterator($dirIterator);
        foreach ($iterator as $file) {
            if (is_dir($file) || $file->getExtension() != 'php' || in_array($file->getBaseName('.php'), $exclude)) {
                continue;
            }
            $appConfigFile = $file->getPath() . '/app.php';
            if (!is_file($appConfigFile)) {
                continue;
            }
        }
        return $allConfig;
    }
}
