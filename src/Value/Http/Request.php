<?php

namespace Huizi\Dddwork\Value\Http;

class Request extends \Workerman\Protocols\Http\Request
{
    public function __construct($buffer)
    {
        parent::__construct($buffer);
    }
}
