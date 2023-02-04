<?php

namespace DTL\OpenApi;

use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\Mapper\TreeMapper;
use DTL\OpenApi\Attributes\ParamIn;
use DTL\OpenApi\Metadata\BodyMetadata;
use DTL\OpenApi\Metadata\MethodMetadata;
use RuntimeException;

class ArgumentResolver
{
    public function __construct(private TreeMapper $mapper)
    {
    }

    /**
     * @return array<string,mixed>
     * @param array<int,mixed> $attributes
     */
    public function resolveArguments(MethodMetadata $metadata, ArgumentsSource $source): array
    {
        $arguments = [];
        foreach ($metadata->params as $parameter) {
            $arguments[$parameter->name] = match ($parameter->in) {
                ParamIn::PATH => $this->extract($parameter->in, $source->path, $parameter->name),
                default => throw new RuntimeException(sprintf(
                    'Unsupported param in: %s',
                    $parameter->in
                ))
            };
        }
        if ($metadata->body) {
            $arguments = (function (BodyMetadata $body) use ($arguments, $source) {
                $arguments[$body->param] = $this->mapper->map($body->type, Source::json($source->requestBody()));
                return $arguments;
            })($metadata->body);
        }

        return $arguments;
    }

    /**
     * @param array<string,mixed> $data
     */
    private function extract(ParamIn $type, array $data, string $key): mixed
    {
        if (!isset($data[$key])) {
            throw new RuntimeException(sprintf(
                'Could not find "%s" in %s, known keys: "%s"',
                $key,
                $type->value,
                implode('", "', array_keys($data))
            ));
        }

        return $data[$key];
    }
}
