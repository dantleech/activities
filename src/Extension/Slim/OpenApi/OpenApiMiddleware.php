<?php

namespace Activities\Extension\Slim\OpenApi;

use ArgumentCountError;
use DTL\OpenApi\ArgumentResolver;
use DTL\OpenApi\ArgumentsSource;
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
    public function __construct(
        private ContainerInterface $container,
        private MethodMetadatas $methodMetadatas,
        private ArgumentResolver $argumentResolver,
    )
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
        $metadata = $this->methodMetadatas->get($classFqn, $methodName);

        if (null === $metadata) {
            return $handler->handle($request);
        }

        $handler = $this->container->get($classFqn);

        if (!method_exists($handler, $methodName)) {
            throw new RuntimeException(sprintf(
                'Method "%s" does not exist on "%s"',
                $methodName, get_class($handler)
            ));
                
        }

        try {
            $output = $handler->$methodName(...$this->argumentResolver->resolveArguments(
                $metadata,
                ArgumentsSource::fromPsrServerRequest($request)->withPathParameters($route->getArguments()),
            ));
        } catch (ArgumentCountError $error) {
            throw new RuntimeException(sprintf(
                'Invalid parameters passed to %s:%s: %s',
                get_class($handler),
                $methodName,
                $error->getMessage()
            ));
        }

        return new JsonResponse($output);
    }
}
