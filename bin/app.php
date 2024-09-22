#!/usr/bin/env php
<?php

use AuditLog\App\Factory\ContainerFactory;
use AuditLog\Controller\ProcessAuditLogLoopController;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\CommandLoader\ContainerCommandLoader;

require __DIR__ . '/../vendor/autoload.php';

$application = new Application();
$container = ContainerFactory::buildContainer();

$application->setCommandLoader(new ContainerCommandLoader(
    $container,
    [
        ProcessAuditLogLoopController::COMMAND_NAME => ProcessAuditLogLoopController::class,
    ]
));

$application->run();
