<?php

namespace Huizi\Dddwork\Framework\Http;

class Request extends \Workerman\Protocols\Http\Request
{
    public function __construct($buffer)
    {
        parent::__construct($buffer);
    }
}
