<?php

namespace Untek\Framework\Console\Domain\Factories;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Untek\Core\App\Interfaces\AppInterface;
use Untek\Core\DotEnv\Domain\Libs\Vlucas\VlucasBootstrap;
use Untek\Framework\Console\Domain\Libs\ConsoleApp;

class ConsoleApplicationFactory extends BaseConsoleApplicationFactory
{

    public function __construct(protected ContainerInterface $container)
    {
    }

    protected function initApp(): void
    {
        $consoleAppClass = $this->getConsoleAppClass();
        $this->getContainerConfigurator()->singleton(AppInterface::class, $consoleAppClass);
        $this->getApp()->init();
    }

    public function createApplicationInstance(): Application
    {
        $this->initApp();
        return $this->getConsoleApplicationInstance();
    }

    protected function getConsoleAppClass(): string
    {
        if (getenv('CONSOLE_APP_CLASS')) {
            $consoleAppClass = getenv('CONSOLE_APP_CLASS');
        } else {
            $mainEnvFile = __DIR__ . '/../../../../../../.env';
            $bootstrap = new VlucasBootstrap();
            $mainEnv = $bootstrap->parseFile($mainEnvFile);
            $consoleAppClass = $mainEnv['CONSOLE_APP_CLASS'] ?? ConsoleApp::class;
        }
        return $consoleAppClass;
    }
}
