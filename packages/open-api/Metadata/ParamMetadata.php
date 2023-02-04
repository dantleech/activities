<?php

namespace DTL\OpenApi\Metadata;

use DTL\OpenApi\Attributes\ParamIn;

class ParamMetadata
{
    public function __construct(
        public string $name,
        public ParamIn $in,
    ) {
    }
}
