<?php

namespace Untek\Framework\Console\Infrastructure\Cli\Server;

use Untek\Core\App\Bootstrap\ConfigDirectory;
use Forecast\Map\Shared\Infrastructure\Bootstrap\Kernel;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;

class CliKernel
{

    protected Kernel $kernel;
    protected ConfigDirectory $configDirectory;
    protected string $cacheDirectory;
    protected bool $isImportLocalConfig = false;
    protected string $context;
    protected string $environment;
    protected bool $isDebug = false;
    protected bool $isTest = false;

    public function __construct(
        string $projectDirectory,
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
        $this->configDirectory = new ConfigDirectory($projectDirectory);
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

    protected function getKernel(): Kernel
    {
        if (!isset($this->kernel)) {
            $kernel = new Kernel($this->configDirectory, $this->context, $this->environment, $this->cacheDirectory, $this->isImportLocalConfig, $this->isDebug, $this->isTest);
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