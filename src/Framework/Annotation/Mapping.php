<?php

namespace Huizi\Dddwork\Framework\Annotation;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
abstract class Mapping
{
    /**
     * @Required()
     * @var string
     */
    public $path;

    /**
     * @var array
     */
    public $params;

    public function getPath()
    {
        return $this->path;
    }

    abstract public function getMethod();

    public function getParams()
    {
        return $this->params;
    }
}
