<?php

namespace DTL\OpenApi\Metadata;

class MethodMetadata
{
    /**
     * @param list<string> $methods
     * @param list<ParamMetadata> $params
     */
    public function __construct(
        public readonly string $classFqn,
        public readonly string $name,
        public string $path,
        public array $methods,
        public array $params,
    ) {
    }
}
