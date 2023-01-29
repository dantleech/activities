<?php

namespace Activities\Extension\Slim\OpenApi;

use DTL\OpenApi\Metadata\MethodMetadatas;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;
use Slim\Routing\Route;

class OpenApiMiddleware implements MiddlewareInterface
{
    public function __construct(private ContainerInterface $container, private MethodMetadatas $methodMetadatas)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $attributes = $request->getAttributes();
        if (!isset($attributes['__route__'])) {
            throw new RuntimeException(
                'Expected `__route__` to be set in the request attributes, but it was not'
            );
        }

        $route = $attributes['__route__'];

        if (!$route instanceof Route) {
            throw new RuntimeException(
                'Expected `__route__` to be an instanceof Slim\Routing\Route got something else'
            );
        }

        $callable = $route->getCallable();

        if (!is_array($callable)) {
            return $handler->handle($request);
        }

        if (count($callable) !== 2) {
            return $handler->handle($request);
        }

        [$classFqn, $methodName] = $callable;

        $handler = $this->container->get($classFqn);

        $output = call_user_func([$handler, $methodName], $request);

        return new JsonResponse($output);
    }
}
