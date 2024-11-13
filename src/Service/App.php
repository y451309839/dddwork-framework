<?php

namespace Huizi\Dddwork\Domain;

use Closure;
use Throwable;
use Monolog\Logger;
use Workerman\Worker;
use Workerman\Protocols\Http;
use Huizi\Dddwork\Base\Config;
use Huizi\Dddwork\Value\Http\Route;
use Huizi\Dddwork\Value\Http\Request;
use Huizi\Dddwork\Value\Http\Response;
use Workerman\Connection\TcpConnection;

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

    public function onMessage(TcpConnection $connection, Request $request)
    {
        try {
            $path = $request->path();
            $method = $request->method();
            $key = $method . ':' . $path;
            if (isset(static::$callbacks[$key])) {
                [$callback, $request->controller, $request->action, $request->route] = static::$callbacks[$key];
                static::send($connection, $callback($request), $request);
                return;
            }
            $route = static::findRoute($method, $path);
            if (!$route) {
                $callback = static::getFallback();
                $request->controller = $request->action = '';
                static::send($connection, $callback($request), $request);
                return null;
            }
            $callback = $route->getCallback();
            // $request->controller = $route->getController();
            // $request->action = $route->getAction();
            $request->route = $route;
            static::send($connection, $callback($request), $request);
        } catch (Throwable $e) {
            static::send($connection, static::exceptionResponse($e, $request), $request);
        }
        return null;
    }

    public function onWorkerStart($worker)
    {
        static::$worker = $worker;
        Http::requestClass(static::$requestClass);
    }

    /**
     * ExceptionResponse.
     * @param Throwable $e
     * @param $request
     * @return Response
     */
    protected static function exceptionResponse(Throwable $e, $request): Response
    {
        $response = new Response(500, [], Config::get('app.debug') ? (string)$e : $e->getMessage());
        $response->exception($e);
        return $response;
    }

    protected static function send($connection, $response, $request)
    {
        $keepAlive = $request->header('connection');
        if ((!$keepAlive && $request->protocolVersion() == '1.1')
            || $keepAlive == 'keep-alive' || $keepAlive == 'Keep-Alive'
        ) {
            $connection->send($response);
            return;
        }
        $connection->close($response);
    }

    protected static function unsafeUri(TcpConnection $connection, string $path, $request): bool
    {
        if (
            !$path ||
            strpos($path, '..') !== false ||
            strpos($path, "\\") !== false ||
            strpos($path, "\0") !== false
        ) {
            $callback = static::getFallback();
            $request->plugin = $request->app = $request->controller = $request->action = '';
            static::send($connection, $callback($request), $request);
            return true;
        }
        return false;
    }

    protected static function getFallback(): Closure
    {
        // when route, controller and action not found, try to use Route::fallback
        return function () {
            try {
                $notFoundContent = file_get_contents(static::$publicPath . '/404.html');
            } catch (Throwable $e) {
                $notFoundContent = '404 Not Found';
            }
            return new Response(404, [], $notFoundContent);
        };
    }

    protected static function findRoute(string $method, string $path) : Route|null
    {

        return new Route('GET', $path, function (Request $request) {
            return new Response(200, [], 'Hello, World!');
        });
    }
}
