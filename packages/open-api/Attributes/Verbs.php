<?php

namespace DTL\OpenApi\Attributes;

use Attribute;

#[Attribute()]
class Verbs
{
    /**
     * @param string[] $verbs
     */
    public function __construct(public array $verbs) {}
}
