<?php

namespace Activities\Activities\Extension;

use Phpactor\Container\ContainerBuilder;
use Phpactor\Container\Extension;
use Phpactor\MapResolver\Resolver;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;

class AppExtension implements Extension
{
    public function load(ContainerBuilder $container): void
    {
        $container->register(App::class, function (ContainerInterface $container) {
            $app = AppFactory::create(null, $container);
            return $app;
        });
    }

    public function configure(Resolver $schema): void
    {
    }
}
