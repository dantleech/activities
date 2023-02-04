<?php

namespace Activities\Tests\Support\Client;

use CuyZ\Valinor\Mapper\TreeMapper;
use Laminas\Diactoros\CallbackStream;
use Laminas\Diactoros\Request;
use Psr\Http\Client\ClientInterface;
use CuyZ\Valinor\Mapper\Source\Source;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

final class RequestHandler
{
    public function __construct(private ClientInterface $client, private TreeMapper $mapper, private SerializerInterface $serializer)
    {
    }

    /**
     * @template T of object
     * @param class-string<T> $type
     * @return T
     */
    public function get(string $path, string $type): object
    {
        $response = $this->client->sendRequest(new Request($path, 'GET'));
        return $this->mapper->map($type, Source::json($response->getBody()->getContents()));
    }

    /**
     * @template T of object
     * @param class-string<T> $type
     * @return T
     */
    public function post(string $path, string $type, object $object): object
    {
        $request = new Request(
            $path,
            'POST',
            new CallbackStream(fn () => $this->serialize($object))
        );
        $response = $this->client->sendRequest($request);
        return $this->mapper->map($type, Source::json($response->getBody()->getContents()));
    }

    private function serialize(object $object): string
    {
        return $this->serializer->serialize($object, 'json');
    }
}
