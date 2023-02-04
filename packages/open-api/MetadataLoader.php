<?php

namespace DTL\OpenApi;

use DTL\OpenApi\Attributes\Param;
use DTL\OpenApi\Attributes\Path;
use DTL\OpenApi\Metadata\MethodMetadata;
use DTL\OpenApi\Metadata\MethodMetadatas;
use DTL\OpenApi\Metadata\ParamMetadata;
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
                $params = [];

                foreach ($method->getAttributes() as $attribute) {
                    $attribute = $attribute->newInstance();
                    if ($attribute instanceof Path) {
                        $path = $attribute->path;
                    }
                    if ($attribute instanceof Param) {
                        $params[] = new ParamMetadata($attribute->name, $attribute->in);
                    }
                }

                $methods[] = new MethodMetadata(
                    $fqn,
                    $method->name,
                    $path,
                    $verbs,
                    $params,
                );
            }
        }

        return new MethodMetadatas($methods);
    }
}
