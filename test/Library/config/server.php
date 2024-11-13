<?php

use Huizi\Dddwork\Base\Path;
use Huizi\Dddwork\Base\System;

/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

return [
    'listen' => 'http://0.0.0.0:8787',
    'transport' => 'tcp',
    'context' => [],
    'name' => 'webman',
    'count' => System::cpuCount() * 4,
    'user' => '',
    'group' => '',
    'reusePort' => false,
    'event_loop' => '',
    'stop_timeout' => 2,
    'pid_file' => Path::runtime() . '/webman.pid',
    'status_file' => Path::runtime() . '/webman.status',
    'stdout_file' => Path::runtime() . '/logs/stdout.log',
    'log_file' => Path::runtime() . '/logs/workerman.log',
    'max_package_size' => 10 * 1024 * 1024
];
