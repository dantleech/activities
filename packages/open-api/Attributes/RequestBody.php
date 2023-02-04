<?php

namespace DTL\OpenApi\Attributes;

use Attribute;

#[Attribute()]
class RequestBody
{
    public function __construct(public string $type, public string $param)
    {
    }
}
