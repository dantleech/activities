<?php

namespace Activities;

use Activities\Extension\Api\ApiExtension;
use Activities\Extension\App\AppExtension;
use Activities\Extension\Slim\SlimExtension;
use Activities\Extension\Console\ConsoleExtension;
use Activities\Extension\Doctrine\DoctrineExtension;
use Phpactor\Container\PhpactorContainer;

final class ContainerFactory
{
    public static function container(): PhpactorContainer
    {
        return PhpactorContainer::fromExtensions([
            SlimExtension::class,
            ConsoleExtension::class,
            DoctrineExtension::class,
            AppExtension::class,
            ApiExtension::class,
        ]);
    }
}
