<?php

namespace Activities\Tests\Api;

use Activities\Tests\IntegrationTestCase;
use Laminas\Diactoros\ServerRequest;
use Slim\App;

class ActivitiesTest extends IntegrationTestCase
{
    public function testGet(): void
    {
        $response = $this->container()->get(App::class)->handle(
            new ServerRequest([], [], '/v1/activities/1234-1234-1234-1234'),
        );

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('{}', $response->getBody()->getContents());
    }
}
