<?php

namespace Test;

class TestCase extends \PHPUnit\Framework\TestCase
{
    
    protected function shouldSkipTest(): bool
    {
        $argv = (array)$_SERVER['argv'];
        $hasFilter = false;
        foreach ($argv as $arg) {
            if (strpos($arg, '--filter') !== false) {
                $hasFilter = true;
                break;
            }
        }
 
        return !$hasFilter;
    }
}
