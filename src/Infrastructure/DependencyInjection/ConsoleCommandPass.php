<?php

namespace Untek\Framework\Console\Infrastructure\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Untek\Framework\Console\Symfony4\Interfaces\CommandConfiguratorInterface;

class ConsoleCommandPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container): void
    {
        try {
            $definition = $container->findDefinition(CommandConfiguratorInterface::class);
            $commandServices = $container->findTaggedServiceIds('console.command', true);
            foreach ($commandServices as $cliCommandClass => $tags) {
                $definition->addMethodCall('registerCommandClass', [$cliCommandClass]);
            }
        } catch (ServiceNotFoundException $e) {
        }
    }
}