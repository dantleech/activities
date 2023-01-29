<?php

namespace DTL\OpenApi\Attributes;

use Attribute;

#[Attribute()]
class Description
{
    public function __construct(public $description) {}
}
