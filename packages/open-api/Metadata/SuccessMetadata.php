<?php

namespace DTL\OpenApi\Metadata;

final class SuccessMetadata
{
    public function __construct(
        public int $code,
    ) {
    }
}
