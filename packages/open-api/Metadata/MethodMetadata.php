<?php

namespace DTL\OpenApi\Metadata;

use DTL\OpenApi\Attributes\Path;
use RuntimeException;

class MethodMetadata
{
    /**
     * @param list<string> $methods
     */
    public function __construct(
        public readonly string $classFqn,
        public readonly string $name,
        public string $path,
        public array $methods,
    ) {
    }
}
