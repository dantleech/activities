<?php

namespace DTL\OpenApi\Attributes;

use Attribute;

#[Attribute()]
class Success
{
    /**
     * @param null|class-string $type
     */
    public function __construct(
        public readonly int $code,
        public readonly ?string $type = null,
    )
    {
    }
}
