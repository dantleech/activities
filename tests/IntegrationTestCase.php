<?php

namespace Activities\Tests;

use Activities\ContainerFactory;
use Activities\Tests\Support\AppHttpClient;
use Activities\Tests\Support\Client\RequestHandler;
use Activities\Tests\Support\Client\TestClient;
use CuyZ\Valinor\MapperBuilder;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Slim\App;
use Symfony\Component\Serializer\SerializerInterface;

class IntegrationTestCase extends TestCase
{
    private ?ContainerInterface $container = null;

    public function apiClient(): TestClient
    {
        return new TestClient(
            new RequestHandler(
                new AppHttpClient($this->container()->get(App::class)),
                (new MapperBuilder())->mapper(),
                $this->container()->get(SerializerInterface::class),
            ),
        );
    }

    public function container(): ContainerInterface
    {
        if ($this->container) {
            return $this->container;
        }

        $this->container = ContainerFactory::container();

        return $this->container;
    }
}
