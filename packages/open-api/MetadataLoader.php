<?php

namespace DTL\OpenApi;

use DTL\OpenApi\Attributes\Param;
use DTL\OpenApi\Attributes\Path;
use DTL\OpenApi\Attributes\RequestBody;
use DTL\OpenApi\Attributes\Success;
use DTL\OpenApi\Attributes\Verbs;
use DTL\OpenApi\Metadata\BodyMetadata;
use DTL\OpenApi\Metadata\MethodMetadata;
use DTL\OpenApi\Metadata\MethodMetadatas;
use DTL\OpenApi\Metadata\ParamMetadata;
use DTL\OpenApi\Metadata\SuccessMetadata;
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
                $body = null;
                $success = new SuccessMetadata(200);

                foreach ($method->getAttributes() as $attribute) {
                    $attribute = $attribute->newInstance();
                    if ($attribute instanceof Path) {
                        $path = $attribute->path;
                    }
                    if ($attribute instanceof Param) {
                        $params[] = new ParamMetadata($attribute->name, $attribute->in);
                    }
                    if ($attribute instanceof Verbs) {
                        $verbs = $attribute->verbs;
                    }
                    if ($attribute instanceof Success) {
                        $success = new SuccessMetadata($attribute->code);
                    }
                    if ($attribute instanceof RequestBody) {
                        $body = new BodyMetadata($attribute->type, $attribute->param);
                    }
                }

                if (!$path) {
                    continue;
                }

                $methods[] = new MethodMetadata(
                    $fqn,
                    $method->name,
                    $path,
                    $verbs,
                    $params,
                    $body,
                    $success,
                );
            }
        }

        return new MethodMetadatas($methods);
    }
}
