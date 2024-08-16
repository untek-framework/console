<?php

namespace Untek\Framework\Console\Symfony4\Libs;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Untek\Core\Code\Helpers\DeprecateHelper;
use Untek\Framework\Console\Symfony4\Interfaces\CommandConfiguratorInterface;

DeprecateHelper::hardThrow();

class InMemoryCommandConfigurator extends BaseCommandConfigurator
{

    /** @var array | object[] */
    protected $commandInstances = [];

    public function __construct(protected ContainerInterface $container, protected ?LoggerInterface $logger = null)
    {
    }

    public function registerCommandInstance(Command $commandInstance): void
    {
        $this->commandInstances[] = $commandInstance;
    }

    /**
     * @return array|object[]
     */
    public function getCommandInstances(): array
    {
        return $this->commandInstances;
    }
}
