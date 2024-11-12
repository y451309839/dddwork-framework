<?php

namespace Huizi\Dddwork;

use Monolog\Logger;

class App
{

    /**
     * @var callable[]
     */
    protected static $callbacks = [];

    /**
     * @var Worker
     */
    protected static $worker = null;

    /**
     * @var Logger
     */
    protected static $logger = null;

    /**
     * @var string
     */
    protected static $appPath = '';

    /**
     * @var string
     */
    protected static $publicPath = '';

    /**
     * @var string
     */
    protected static $requestClass = '';
    
    public function __construct(string $requestClass, Logger $logger, string $appPath, string $publicPath)
    {
        static::$requestClass = $requestClass;
        static::$logger = $logger;
        static::$publicPath = $publicPath;
        static::$appPath = $appPath;
    }
}
