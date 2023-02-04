<?php

namespace Activities\Extension\App;

use Activities\Entity\Activity;
use Activities\Entity\ActivityRepository;
use Activities\Extension\Api\ApiExtension;
use Activities\Handler\ActivitiesHandler;
use Doctrine\ORM\EntityManagerInterface;
use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpactor\Container\Extension;
use Phpactor\MapResolver\Resolver;

class AppExtension implements Extension
{
    public function load(ContainerBuilder $container): void
    {
        $container->register(ActivitiesHandler::class, function (Container $container) {
            return new ActivitiesHandler($container->get(ActivityRepository::class));
        }, [
            ApiExtension::TAG_HANDLER => [],
        ]);

        $container->register(ActivityRepository::class, function (Container $container) {
            return $container->get(EntityManagerInterface::class)->getRepository(Activity::class) ;
        });
    }

    public function configure(Resolver $schema): void
    {
    }
}
