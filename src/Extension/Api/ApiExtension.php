<?php

namespace Activities\Extension\Api;

use DTL\OpenApi\MetadataLoader;
use DTL\OpenApi\Metadata\MethodMetadatas;
use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpactor\Container\Extension;
use Phpactor\MapResolver\Resolver;

class ApiExtension implements Extension
{
    public const TAG_HANDLER = 'api_handler';

    public function load(ContainerBuilder $container): void
    {
        $container->register(MethodMetadatas::class, function (Container $continer) {
            return (new MetadataLoader())->load(
                array_keys($continer->getServiceIdsForTag(self::TAG_HANDLER))
            );
        });
    }

    public function configure(Resolver $schema): void
    {
    }
}
