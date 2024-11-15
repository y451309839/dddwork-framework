<?php

namespace Huizi\Dddwork\Adapter\Workerman;

use Huizi\Dddwork\Base\Log;
use Huizi\Dddwork\Base\Config;
use Huizi\Dddwork\Base\System;
use Huizi\Dddwork\Framework\App;
use Workerman\Worker as Workerman;
use Huizi\Dddwork\Framework\Http\Request;
use Huizi\Dddwork\Contract\Outbound\WorkerInterface;

class Worker implements WorkerInterface
{
    protected $worker;

    public function __construct(array $config)
    {
        $this->worker = new Workerman($config['listen'], $config['context']);
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
                $this->worker->$property = $config[$property];
            }
        }
    }

    public function start()
    {
        $this->worker->onWorkerStart = function ($worker) {
            $app = new App(Config::get('app.request_class', Request::class), Log::channel('default'), System::appPath(), System::publicPath());
            $worker->onMessage = [$app, 'onMessage'];
            call_user_func([$app, 'onWorkerStart'], $worker);
        };
        Workerman::runAll();
    }
}
