<?php

namespace Huizi\Dddwork;

use RuntimeException;
use Huizi\Dddwork\Base\Config;
use Huizi\Dddwork\Base\System;
use Huizi\Dddwork\Adapter\Workerman\WorkerFactory;

class Server {

    public function __construct($basePath) {
        System::setBasePath($basePath);
        
        ini_set('display_errors', 'on');
        error_reporting(E_ALL);

        static::loadAllConfigs();
    }

    public function run() {
        $runtimeLogsPath = System::runtimePath() . DIRECTORY_SEPARATOR . 'logs';
        if (!file_exists($runtimeLogsPath) || !is_dir($runtimeLogsPath)) {
            if (!mkdir($runtimeLogsPath, 0777, true)) {
                throw new RuntimeException("创建运行时日志目录失败: {$runtimeLogsPath}，请检查权限");
            }
        }

        $config = Config::get('server');
        $worker = WorkerFactory::create($config);
        $worker->start();
    }

    public function loadAllConfigs(array $exclude = [])
    {
        Config::load(System::configPath(), $exclude);
    }



}