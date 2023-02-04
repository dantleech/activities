<?php

namespace DTL\OpenApi\Metadata;

use DTL\OpenApi\Attributes\ParamIn;

class ParamMetadata
{
    public function __construct(
        public readonly string $name,
        public readonly ParamIn $in,
    ) {
    }
}
