<?php

namespace Activities\Tests\Support\Client;

use CuyZ\Valinor\MapperBuilder;
use CuyZ\Valinor\Mapper\TreeMapper;
use Laminas\Diactoros\CallbackStream;
use Laminas\Diactoros\Request;
use Psr\Http\Client\ClientInterface;
use CuyZ\Valinor\Mapper\Source\Source;

final class RequestHandler
{
    private TreeMapper $mapper;

    public function __construct(private ClientInterface $client, TreeMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @template T
     * @param class-string<T> $type
     * @return T
     */
    public function get(string $path, string $type): object
    {
        $response = $this->client->sendRequest(new Request($path, 'GET'));
        return $this->mapper->map($type, Source::json($response->getBody()->getContents()));
    }

    /**
     * @template T
     * @param class-string<T> $type
     * @return T
     */
    public function post(string $path, string $type, object $object): object
    {
        $response = $this->client->sendRequest(new Request($path, 'POST', new CallbackStream(fn () => json_encode($object))));
        return (new MapperBuilder())->mapper()->map($type, Source::json($response->getBody()->getContents()));
    }
}
