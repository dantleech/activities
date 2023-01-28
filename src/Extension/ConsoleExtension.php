<?php

namespace Activities\Activities\Extension;

use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpactor\Container\Extension;
use Phpactor\MapResolver\Resolver;
use Symfony\Component\Console\Application;

class ConsoleExtension implements Extension
{
    public function load(ContainerBuilder $container): void
    {
        $container->register(Application::class, function (Container $container) {
            $application = new Application();
            return $application;
        });
    }

    public function configure(Resolver $schema): void
    {
    }
}
