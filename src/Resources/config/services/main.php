<?php

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Untek\Framework\Console\Symfony4\Interfaces\CommandConfiguratorInterface;
use Untek\Framework\Console\Symfony4\Libs\InMemoryCommandConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services->set(CommandConfiguratorInterface::class, InMemoryCommandConfigurator::class)
        ->args(
            [
                service(ContainerInterface::class),
                service(LoggerInterface::class),
            ]
        );
};