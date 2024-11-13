<?php

namespace Huizi\Dddwork\Base;

class System
{
    public static function cpuCount(): int
    {
        // Windows does not support the number of processes setting.
        if (DIRECTORY_SEPARATOR === '\\') {
            return 1;
        }
        $count = 4;
        if (is_callable('shell_exec')) {
            if (strtolower(PHP_OS) === 'darwin') {
                $count = (int)shell_exec('sysctl -n machdep.cpu.core_count');
            } else {
                $count = (int)shell_exec('nproc');
            }
        }
        return $count > 0 ? $count : 4;
    }
}
