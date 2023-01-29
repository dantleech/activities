<?php

namespace DTL\OpenApi\Attributes;

use Attribute;

#[Attribute()]
class Response
{
    /**
     * @param class-string $type
     */
    public function __construct(int $code, string $type)
    {
    }
}
