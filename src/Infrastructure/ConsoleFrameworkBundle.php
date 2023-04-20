<?php

namespace Untek\Framework\Console\Infrastructure;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Untek\Core\Kernel\Bundle\BaseBundle;

class ConsoleFrameworkBundle extends BaseBundle
{
    public function getName(): string
    {
        return 'console-framework';
    }

    public function build(ContainerBuilder $containerBuilder)
    {
        $this->importServices($containerBuilder, __DIR__ . '/../Resources/config/services/main.php');
    }
}
