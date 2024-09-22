<?php

declare(strict_types=1);

namespace AuditLog\App\Factory;

use AuditLog\ApplicationConfig;
use DI\Container;
use DI\ContainerBuilder;

/**
 * @internal This class is considered internal and should not be used outside of AuditLog
 */
class ContainerFactory
{
    public static function buildContainer(): Container
    {
        $container = new ContainerBuilder();
        $container->useAutowiring(true);
        $container->addDefinitions(new ApplicationConfig());
        return  $container->build();
    }
}
