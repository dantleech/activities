<?php

namespace Activities\Extension\Slim;

use Activities\Extension\Slim\OpenApi\OpenApiMiddleware;
use CuyZ\Valinor\MapperBuilder;
use CuyZ\Valinor\Mapper\TreeMapper;
use DTL\OpenApi\ArgumentResolver;
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
                $app->map($method->verbs, $method->path, [
                    $method->classFqn,
                    $method->name,
                ]);
            }
            $app->addMiddleware($container->get(OpenApiMiddleware::class));
            $app->addRoutingMiddleware();
            return $app;
        });

        $container->register(OpenApiMiddleware::class, function (Container $container) {
            return new OpenApiMiddleware(
                $container,
                $container->get(MethodMetadatas::class),
                $container->get(ArgumentResolver::class)
            );
        });

        $container->register(ArgumentResolver::class, function (Container $container) {
            return new ArgumentResolver($container->get(TreeMapper::class));
        });

        $container->register(TreeMapper::class, function (Container $container) {
            return (new MapperBuilder())->mapper();
        });

    }

    public function configure(Resolver $schema): void
    {
    }
}
