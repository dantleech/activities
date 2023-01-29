<?php

namespace Activities;

use Activities\Extension\App\AppExtension;
use Activities\Extension\Console\ConsoleExtension;
use Activities\Extension\Doctrine\DoctrineExtension;
use Phpactor\Container\PhpactorContainer;

final class ContainerFactory
{
    public static function container(): PhpactorContainer
    {
        return PhpactorContainer::fromExtensions([
            AppExtension::class,
            ConsoleExtension::class,
            DoctrineExtension::class,
        ]);
    }
}
