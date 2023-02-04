<?php

namespace DTL\OpenApi\Metadata;

class MethodMetadata
{
    /**
     * @param list<string> $methods
     * @param list<ParamMetadata> $params
     * @param list<string> $verbs
     */
    public function __construct(
        public readonly string $classFqn,
        public readonly string $name,
        public string $path,
        public array $verbs,
        public array $params,
        public ?BodyMetadata $body = null,
    ) {
    }
}
