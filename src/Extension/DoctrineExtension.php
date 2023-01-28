<?php

namespace Activities\Activities\Extension;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand;
use Doctrine\ORM\Tools\Console\EntityManagerProvider;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpactor\Container\Extension;
use Phpactor\MapResolver\Resolver;

class DoctrineExtension implements Extension
{
    public function load(ContainerBuilder $container): void
    {
        $container->register(EntityManager::class, function (Container $container) {
            $config = ORMSetup::createAttributeMetadataConfiguration(
                paths: [__DIR__.'/../Model'],
                isDevMode: true,
            );
            $connection = DriverManager::getConnection([
                'driver' => 'pdo_sqlite',
                'path' => __DIR__ . '/../../cache/db.sqlite',
            ], $config);

            return new EntityManager($connection, $config);
        });

        $container->register(EntityManagerProvider::class, function (Container $container) {
            return new SingleManagerProvider($container->get(EntityManager::class));
        });

        $container->register(UpdateCommand::class, function (Container $container) {
            return new UpdateCommand($container->get(EntityManagerProvider::class));
        }, [
            ConsoleExtension::TAG_CONSOLE_COMMAND => [],
        ]);
    }


    public function configure(Resolver $schema): void
    {
    }
}
