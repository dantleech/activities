<?php

namespace DTL\OpenApi\Attributes;

use Attribute;

#[Attribute()]
class Param
{
    public function __construct(string $name, string $description, bool $required = true) {}
}
