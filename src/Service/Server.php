<?php

namespace Huizi\Dddwork\Service;

use RuntimeException;
use Workerman\Worker;
use Huizi\Dddwork\Base\Log;
use Huizi\Dddwork\Base\Path;
use Huizi\Dddwork\Domain\App;
use Huizi\Dddwork\Base\Config;
use Huizi\Dddwork\Value\Http\Request;

class Server {

    public static function run() {
        ini_set('display_errors', 'on');
        error_reporting(E_ALL);

        static::loadAllConfigs();

        $runtimeLogsPath = Path::runtime() . DIRECTORY_SEPARATOR . 'logs';
        if (!file_exists($runtimeLogsPath) || !is_dir($runtimeLogsPath)) {
            if (!mkdir($runtimeLogsPath, 0777, true)) {
                throw new RuntimeException("创建运行时日志目录失败: {$runtimeLogsPath}，请检查权限");
            }
        }

        $config = Config::get('server');
        if ($config['listen']) {
            $worker = new Worker($config['listen'], $config['context']);
            $propertyMap = [
                'name',
                'count',
                'user',
                'group',
                'reusePort',
                'transport',
                'protocol'
            ];
            foreach ($propertyMap as $property) {
                if (isset($config[$property])) {
                    $worker->$property = $config[$property];
                }
            }

            $worker->onWorkerStart = function ($worker) {
                $app = new App(Config::get('app.request_class', Request::class), Log::channel('default'), Path::app(), Path::public());
                $worker->onMessage = [$app, 'onMessage'];
                call_user_func([$app, 'onWorkerStart'], $worker);
            };
        }

        Worker::runAll();
    }

    public static function loadAllConfigs(array $exclude = [])
    {
        Config::load(Path::config(), $exclude);
    }



}