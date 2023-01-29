<?php

namespace Activities\Tests;

use Activities\ContainerFactory;
use PHPUnit\Framework\TestCase;
use Phpactor\Container\Container;

class IntegrationTestCase extends TestCase
{
    public function container(): Container
    {
        return ContainerFactory::container();
    }
}
