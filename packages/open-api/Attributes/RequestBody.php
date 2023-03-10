<?php

namespace DTL\OpenApi\Attributes;

use Attribute;

#[Attribute()]
class RequestBody
{
    /**
     * @param class-string $type
     */
    public function __construct(public string $type, public string $param)
    {
    }
}
