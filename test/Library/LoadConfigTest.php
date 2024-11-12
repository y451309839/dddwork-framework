<?php

namespace Test\Library;

use Test\TestCase;
use Huizi\Dddwork\Internal\Config;

class LoadConfigTest extends TestCase
{
    public function testloadFromDir()
    {
        $this->assertEquals(Config::loadFromDir(__DIR__ . '/config', ['exclude']), [
            'app' => ['app_name' => 'Dddwork Framework'],
            'section' => ['web' => ['domain' => 'http://localhost:8000']]
        ], 'loadFromDir基础方法');
    }

    public function testLoad()
    {
        Config::load(__DIR__ . '/config');
        $this->assertArrayHasKey('app', Config::get(), '获取配置app');
        $this->assertArrayHasKey('section', Config::get(), '获取配置section');
        $this->assertArrayHasKey('app_name', Config::get('app'), '获取app配置');
        $this->assertEquals(Config::get('app.app_name'), 'Dddwork Framework', '获取app.app_name配置');
        $this->assertEquals(Config::get('app.app_title', 'No Title'), 'No Title', '获取app.app_title配置');
    }
}
