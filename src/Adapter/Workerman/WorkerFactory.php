<?php

namespace Huizi\Dddwork\Adapter\Workerman;

use Huizi\Dddwork\Adapter\Workerman\Worker;
use Huizi\Dddwork\Contract\Outbound\WorkerInterface;

class WorkerFactory
{
    public static function create(array $config) : WorkerInterface
    {
        return new Worker($config);
    }
}
