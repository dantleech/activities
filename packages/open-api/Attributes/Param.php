<?php

namespace DTL\OpenApi\Attributes;

use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_METHOD)]
class Param
{
    public function __construct(public string $name, public string $description, public ParamIn $in, public bool $required = true) {
    }
}
