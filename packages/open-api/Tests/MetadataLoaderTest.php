<?php

namespace DTL\OpenApi\Tests;

use DTL\OpenApi\Attributes\ParamIn;
use DTL\OpenApi\MetadataLoader;
use DTL\OpenApi\Metadata\ParamMetadata;
use DTL\OpenApi\Tests\Example\ExampleHandler;
use PHPUnit\Framework\TestCase;

class MetadataLoaderTest extends TestCase
{
    public function testLoadMetadata(): void
    {
        $metadata = (new MetadataLoader())->load([
            ExampleHandler::class
        ]);

        self::assertCount(1, $metadata->methods);
        self::assertEquals('handle', $metadata->methods[0]->name);
        self::assertEquals(ExampleHandler::class, $metadata->methods[0]->classFqn);
        self::assertEquals('/foobar/{location}/{uuid}', $metadata->methods[0]->path);
        self::assertEquals(201, $metadata->methods[0]->success->code);

        (function (ParamMetadata $p) {
            self::assertEquals('uuid', $p->name);
            self::assertEquals(ParamIn::PATH, $p->in);
        })($metadata->methods[0]->params[0]);

        (function (ParamMetadata $p) {
            self::assertEquals('location', $p->name);
            self::assertEquals(ParamIn::PATH, $p->in);
        })($metadata->methods[0]->params[1]);

        (function (ParamMetadata $p) {
            self::assertEquals('from', $p->name);
            self::assertEquals(ParamIn::QUERY, $p->in);
        })($metadata->methods[0]->params[2]);

        (function (ParamMetadata $p) {
            self::assertEquals('X-FOOBAR', $p->name);
            self::assertEquals(ParamIn::HEADER, $p->in);
        })($metadata->methods[0]->params[3]);

        (function (ParamMetadata $p) {
            self::assertEquals('session', $p->name);
            self::assertEquals(ParamIn::COOKIE, $p->in);
        })($metadata->methods[0]->params[4]);
    }
}
