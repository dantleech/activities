<?php

namespace DTL\OpenApi;

use DTL\OpenApi\Attributes\Path;
use DTL\OpenApi\Metadata\MethodMetadata;
use DTL\OpenApi\Metadata\MethodMetadatas;
use ReflectionClass;

final class MetadataLoader
{
    /**
     * @param list<class-string> $classFqns
     */
    public function load(array $classFqns): MethodMetadatas
    {
        $methods = [];
        foreach ($classFqns as $fqn) {
            $reflection = new ReflectionClass($fqn);
            foreach ($reflection->getMethods() as $method) {

                $path = null;
                $verbs = ['GET'];

                foreach ($method->getAttributes() as $attribute) {
                    $attribute = $attribute->newInstance();
                    if ($attribute instanceof Path) {
                        $path = $attribute->path;
                    }
                }

                $methods[] = new MethodMetadata(
                    $fqn,
                    $method->name,
                    $path,
                    $verbs
                );
            }
        }

        return new MethodMetadatas($methods);
    }
}
