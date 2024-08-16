<?php

namespace Untek\Framework\Console\Infrastructure\Cli\Server;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;
use Untek\Core\App\Bootstrap\AbstractAppKernel;
use Untek\Core\App\Bootstrap\ConfigDirectory;
use Untek\Core\Code\Helpers\DeprecateHelper;

DeprecateHelper::hardThrow();

abstract class AbstractCliKernel
{

    protected AbstractAppKernel $kernel;
    protected ConfigDirectory $configDirectory;
    protected string $cacheDirectory;
    protected bool $isImportLocalConfig = false;
    protected string $context;
    protected string $environment;
    protected bool $isDebug = false;
    protected bool $isTest = false;

    abstract protected function createKernel(): AbstractAppKernel;

    public function __construct(
        AbstractAppKernel $kernel,
        ConfigDirectory $configDirectory,
        string $context,
        string $environment,
        string $cacheDirectory,
        bool $isImportLocalConfig = false,
        bool $isDebug = false,
        bool $isTest = false
    )
    {
        $this->context = $context;
        $this->environment = $environment;
        $this->isDebug = $isDebug;
        $this->isTest = $isTest;
        $this->configDirectory = $configDirectory;
        $this->cacheDirectory = $cacheDirectory;
        $this->isImportLocalConfig = $isImportLocalConfig;
    }

    public function getApplication(): Application
    {
        $application = $this->getKernel()->getContainer()->get(Application::class);
        $application
            ->getDefinition()
            ->addOption(new InputOption('--mode', null, InputOption::VALUE_OPTIONAL, 'The run mode (main|test)'));
        return $application;
    }

    protected function getKernel(): AbstractAppKernel
    {
        if (!isset($this->kernel)) {
            $kernel = $this->createKernel();
            $kernel->boot();
            register_shutdown_function([$this, 'terminateClosure']);
            /*register_shutdown_function(function () use ($kernel) {
                $kernel->terminate();
            });*/
            $this->kernel = $kernel;
        }
        return $this->kernel;
    }

    public function terminateClosure(): void
    {
        $this->kernel->terminate();
    }
}