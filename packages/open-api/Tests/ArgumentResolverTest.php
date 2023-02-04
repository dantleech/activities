<?php

namespace DTL\OpenApi\Tests;

use DTL\OpenApi\ArgumentResolver;
use DTL\OpenApi\Attributes\ParamIn;
use DTL\OpenApi\Metadata\MethodMetadata;
use DTL\OpenApi\Metadata\ParamMetadata;
use DTL\OpenApi\Tests\Example\ExampleHandler;
use Generator;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ArgumentResolverTest extends TestCase
{
    /**
     * @dataProvider provideResolveArguments
     * @param array<string,mixed> $expected
     */
    public function testResolveArguments(
        MethodMetadata $metadata,
        ServerRequestInterface $request,
        array $expected,
    ): void
    {
        self::assertEquals($expected, (new ArgumentResolver())->resolveArguments($metadata, $request));
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
            (new ServerRequest(
                serverParams: [],
                uploadedFiles: [],
                uri: '/foobar',
                method: 'GET',
                headers: [],
                cookieParams: [],
                queryParams: [],
            ))->withAttribute('uuid', '1234-1234'),
            [
                'uuid' => '1234-1234',
            ]
        ];
    }
}
