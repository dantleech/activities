<?php

namespace DTL\OpenApi\Attributes;

use Attribute;

#[Attribute()]
class Path
{
    public function __construct(public string $path)
    {
    }
}
