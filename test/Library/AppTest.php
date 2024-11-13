<?php

namespace Test\Library;

use Test\TestCase;
use Huizi\Dddwork\Service\Server;

define('BASE_PATH', __DIR__);

class AppTest extends TestCase
{

    public function testRun()
    {
        if ($this->shouldSkipTest()) {
            $this->assertTrue(true);
            return;
        }
        Server::run();
    }
}
