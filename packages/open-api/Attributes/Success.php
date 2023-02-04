<?php

namespace DTL\OpenApi\Attributes;

use Attribute;

#[Attribute()]
class Success
{
    /**
     * @param null|class-string<T> $type
     */
    public function __construct(int $code, ?string $type = null)
    {
    }
}
