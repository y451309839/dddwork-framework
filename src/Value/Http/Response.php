<?php

namespace Huizi\Dddwork\Value\Http;

use Throwable;

class Response extends \Workerman\Protocols\Http\Response
{

    public function __construct(int $status = 200, array $headers = array(), string $body = '')
    {
        parent::__construct($status, $headers, $body);
    }

    public function exception(Throwable $e)
    {

    }
}
