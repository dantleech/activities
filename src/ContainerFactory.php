<?php

namespace Activities;

use Activities\Extension\AppExtension;
use Activities\Extension\ConsoleExtension;
use Activities\Extension\DoctrineExtension;
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
