<?php

namespace DTL\OpenApi\Metadata;

class BodyMetadata
{
    /**
     * @param class-string $type
     */
    public function __construct(public string $type, public string $param) {}
}
