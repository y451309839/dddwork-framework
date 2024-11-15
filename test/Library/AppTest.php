<?php

namespace Test\Library;

use Test\TestCase;
use Huizi\Dddwork\Server;

class AppTest extends TestCase
{

    public function testRun()
    {
        if ($this->shouldSkipTest()) {
            $this->assertTrue(true);
            return;
        }
        $server = new Server(__DIR__);
        $server->run();
    }
}
