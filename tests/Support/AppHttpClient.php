<?php

namespace Activities\Tests\Support;

use Laminas\Diactoros\ServerRequest;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\App;

class AppHttpClient implements ClientInterface
{
    public function __construct(private App $app)
    {
    }
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->app->handle(new ServerRequest(
            serverParams: [],
            uploadedFiles: [],
            uri: $request->getUri(),
            method: $request->getMethod(),
            headers: $request->getHeaders(),
            body: $request->getBody(),
        ));
    }
}
