<?php

namespace Activities\Activities\Extension;

use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpactor\Container\Extension;
use Phpactor\MapResolver\Resolver;
use Symfony\Component\Console\Application;

class ConsoleExtension implements Extension
{
    public const TAG_CONSOLE_COMMAND = 'console_command';

    public function load(ContainerBuilder $container): void
    {
        $container->register(Application::class, function (Container $container) {
            $application = new Application();
            $application->addCommands(array_map(
                fn (string $serviceId) => $container->get($serviceId),
                array_keys($container->getServiceIdsForTag(self::TAG_CONSOLE_COMMAND))
            ));
            return $application;
        });
    }

    public function configure(Resolver $schema): void
    {
    }
}
