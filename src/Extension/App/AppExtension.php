<?php

namespace Activities\Extension\App;

use Activities\Extension\Api\ApiExtension;
use Activities\Handler\ActivitiesHandler;
use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpactor\Container\Extension;
use Phpactor\MapResolver\Resolver;

class AppExtension implements Extension
{
    public function load(ContainerBuilder $container): void
    {
        $container->register(ActivitiesHandler::class, function (Container $container) {
            return new ActivitiesHandler();
        }, [
            ApiExtension::TAG_HANDLER => [],
        ]);
    }

    public function configure(Resolver $schema): void
    {
    }
}
