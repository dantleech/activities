<?php

namespace DTL\OpenApi\Metadata;

class MethodMetadatas
{
    /**
     * @param list<MethodMetadata> $methods
     */
    public function __construct(public array $methods)
    {
    }

    /**
     * @param class-string $classFqn
     */
    public function get(string $classFqn, string $methodName): ?MethodMetadata
    {
        foreach ($this->methods as $method) {
            if ($classFqn !== $method->classFqn) {
                continue;
            }
            if ($methodName !== $method->name) {
                continue;
            }

            return $method;
        }

        return null;
    }
}
