<?php

namespace DTL\OpenApi\Tests;

use DTL\OpenApi\ArgumentResolver;
use DTL\OpenApi\ArgumentsSource;
use DTL\OpenApi\Attributes\ParamIn;
use DTL\OpenApi\Metadata\MethodMetadata;
use DTL\OpenApi\Metadata\ParamMetadata;
use DTL\OpenApi\Tests\Example\ExampleHandler;
use Generator;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;

class ArgumentResolverTest extends TestCase
{
    /**
     * @dataProvider provideResolveArguments
     * @param array<string,mixed> $expected
     */
    public function testResolveArguments(
        MethodMetadata $metadata,
        ArgumentsSource $source,
        array $expected,
    ): void
    {
        self::assertEquals($expected, (new ArgumentResolver())->resolveArguments($metadata, $source));
    }
    /**
     * @return Generator<array{MethodMetadata,ServerRequest,array<string,string>}>
     */
    public function provideResolveArguments(): Generator
    {
        yield [
            new MethodMetadata(ExampleHandler::class, 'handle', '/path', [], [
                new ParamMetadata('uuid', ParamIn::PATH),
            ]),
            new ArgumentsSource(
                path: ['uuid' => '1234-1234'],
            ),
            [
                'uuid' => '1234-1234',
            ]
        ];
    }
}
