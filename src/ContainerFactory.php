<?php

namespace Activities\Activities;

use Activities\Activities\Extension\AppExtension;
use Activities\Activities\Extension\ConsoleExtension;
use Phpactor\Container\PhpactorContainer;

final class ContainerFactory
{
    public static function container(): PhpactorContainer
    {
        return PhpactorContainer::fromExtensions([
            AppExtension::class,
            ConsoleExtension::class,
        ]);
    }
}
