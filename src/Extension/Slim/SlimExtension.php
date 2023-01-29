<?php

namespace Activities\Extension\Slim;

use Activities\Extension\Slim\OpenApi\OpenApiMiddleware;
use DTL\OpenApi\Metadata\MethodMetadatas;
use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpactor\Container\Extension;
use Phpactor\MapResolver\Resolver;
use Slim\App;
use Slim\Factory\AppFactory;

class SlimExtension implements Extension
{
    public function load(ContainerBuilder $container): void
    {
        $container->register(App::class, function (Container $container) {
            $app = AppFactory::create(null, $container);
            foreach ($container->get(MethodMetadatas::class)->methods as $method) {
                $app->map($method->methods, $method->path, [
                    $method->classFqn,
                    $method->name,
                ]);
            }
            $app->addMiddleware($container->get(OpenApiMiddleware::class));
            $app->addRoutingMiddleware();
            return $app;
        });

        $container->register(OpenApiMiddleware::class, function (Container $container) {
            return new OpenApiMiddleware($container, $container->get(MethodMetadatas::class));
        });
    }

    public function configure(Resolver $schema): void
    {
    }
}
