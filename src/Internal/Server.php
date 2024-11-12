<?php

namespace Interal;

use RuntimeException;
use Workerman\Worker;
use Huizi\Dddwork\App;
use Huizi\Dddwork\Internal\Log;
use Huizi\Dddwork\Internal\Config;
use Workerman\Protocols\Http\Request;

class Server {

    public static function run() {
        ini_set('display_errors', 'on');
        error_reporting(E_ALL);

        static::loadAllConfigs(['route']);

        $runtimeLogsPath = runtime_path() . DIRECTORY_SEPARATOR . 'logs';
        if (!file_exists($runtimeLogsPath) || !is_dir($runtimeLogsPath)) {
            if (!mkdir($runtimeLogsPath, 0777, true)) {
                throw new RuntimeException("Failed to create runtime logs directory. Please check the permission.");
            }
        }

        $config = config('server');
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
                require_once base_path() . '/support/bootstrap.php';
                $app = new App(config('app.request_class', Request::class), Log::channel('default'), app_path(), public_path());
                $worker->onMessage = [$app, 'onMessage'];
                call_user_func([$app, 'onWorkerStart'], $worker);
            };
        }

        Worker::runAll();
    }

    public static function loadAllConfigs(array $exclude = [])
    {
        Config::load(config_path(), $exclude);
    }

}