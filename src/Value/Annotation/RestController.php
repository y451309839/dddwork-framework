<?php

namespace Huizi\Dddwork\Value\Annotation;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class RestController
{
    public $prefix;

    public function __construct($prefix = '')
    {
        $this->prefix = $prefix;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }
}
