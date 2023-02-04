<?php

namespace DTL\OpenApi\Tests;

use DTL\OpenApi\ArgumentsSource;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;

class ArgumentsSourceTest extends TestCase
{
    public function testFromPsrServerRequest(): void
    {
        $source = ArgumentsSource::fromPsrServerRequest(
            (new ServerRequest(
                serverParams: [],
                uploadedFiles: [],
                uri: '/foobar',
                method: 'GET',
                cookieParams: [],
                queryParams: [
                    'foo' => 'bar',
                ],
            ))->withHeader('FOO', 'foo'),
        )->withPathParameters([
            'uuid' => '1234-1234',
        ]);

        self::assertEquals(['uuid' => '1234-1234'], $source->path);
        self::assertEquals(['foo' => 'bar'], $source->query);
        self::assertEquals(['FOO' => 'foo'], $source->header);
    }
}
