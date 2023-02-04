<?php

namespace DTL\OpenApi\Metadata;

class MethodMetadata
{
    /**
     * @param list<string> $verbs
     * @param list<ParamMetadata> $params
     * @param list<string> $verbs
     * @param class-string $classFqn
     */
    public function __construct(
        public readonly string $classFqn,
        public readonly string $name,
        public readonly string $path,
        public readonly array $verbs,
        public readonly array $params,
        public readonly ?BodyMetadata $body = null,
        public readonly ?SuccessMetadata $success = null,
    ) {
    }
}
