<?php

namespace Activities\Extension\Slim\OpenApi;

use ArgumentCountError;
use DTL\OpenApi\ArgumentResolver;
use DTL\OpenApi\ArgumentsSource;
use DTL\OpenApi\Metadata\MethodMetadatas;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\Route;
use Symfony\Component\Serializer\SerializerInterface;

class OpenApiMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ContainerInterface $container,
        private MethodMetadatas $methodMetadatas,
        private ArgumentResolver $argumentResolver,
        private SerializerInterface $serializer,
    ) {
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
                $methodName,
                get_class($handler)
            ));
        }

        $argumentSource = ArgumentsSource::fromPsrServerRequest($request);
        $argumentSource = $argumentSource->withPathParameters($route->getArguments());
        $argumentSource = $argumentSource->withBodyReader(function () use ($request) {
            return $request->getBody()->getContents();
        });

        try {
            $output = $handler->$methodName(...$this->argumentResolver->resolveArguments(
                $metadata,
                $argumentSource,
            ));
        } catch (ArgumentCountError $error) {
            throw new RuntimeException(sprintf(
                'Invalid parameters passed to %s:%s: %s',
                get_class($handler),
                $methodName,
                $error->getMessage()
            ));
        }

        if (null === $output) {
            throw new HttpNotFoundException($request, sprintf('Not found [%s] %s', $request->getMethod(), $request->getUri()));
        }

        $response = new Response();
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->withStatus($metadata->success->code);
        $response->getBody()->write($this->serializer->serialize($output, 'json'));

        return $response;
    }
}
