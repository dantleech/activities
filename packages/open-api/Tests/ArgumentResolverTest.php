<?php

namespace DTL\OpenApi\Tests;

use CuyZ\Valinor\MapperBuilder;
use DTL\OpenApi\ArgumentResolver;
use DTL\OpenApi\ArgumentsSource;
use DTL\OpenApi\Attributes\ParamIn;
use DTL\OpenApi\Metadata\BodyMetadata;
use DTL\OpenApi\Metadata\MethodMetadata;
use DTL\OpenApi\Metadata\ParamMetadata;
use DTL\OpenApi\Tests\Example\ExampleHandler;
use Generator;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use stdClass;

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
        self::assertEquals($expected, (new ArgumentResolver(
            (new MapperBuilder())->mapper(),
        ))->resolveArguments($metadata, $source));
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

        yield [
            new MethodMetadata(
                ExampleHandler::class,
                'handleNew',
                '/path',
                [],
                [
                    new ParamMetadata('uuid', ParamIn::PATH)
                ],
                body: new BodyMetadata(type: 'stdClass', param: 'foo')
            ),
            new ArgumentsSource(
                path: ['uuid' => '1234-1234'],
                bodyReader: fn () => '{}',
            ),
            [
                'uuid' => '1234-1234',
                'foo' => new stdClass(),
            ]
        ];
    }
}
