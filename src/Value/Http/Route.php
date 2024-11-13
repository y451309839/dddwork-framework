<?php

namespace Huizi\Dddwork\Value\Http;

class Route
{
    protected $method;

    protected $path;

    protected $callback;

    public function __construct($method, string $path, $callback)
    {
        $this->method = (array)$method;
        $this->path = $path;
        $this->callback = $callback;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getCallback()
    {
        return $this->callback;
    }
}
