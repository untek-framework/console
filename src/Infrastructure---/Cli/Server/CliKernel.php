<?php

namespace Untek\Framework\Console\Infrastructure\Cli\Server;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;
use Untek\Core\App\Bootstrap\AbstractAppKernel;

class CliKernel
{

    protected AbstractAppKernel $kernel;
    protected string $cacheDirectory;
    protected bool $isImportLocalConfig = false;
    protected string $context;
    protected string $environment;
    protected bool $isDebug = false;
    protected bool $isTest = false;

    protected function createKernel(): AbstractAppKernel
    {
        return $this->kernel;
    }

    public function __construct(
        AbstractAppKernel $kernel,
        string $context,
        string $environment,
        string $cacheDirectory,
        bool $isImportLocalConfig = false,
        bool $isDebug = false,
        bool $isTest = false
    )
    {
        $this->kernel = $kernel;
        $this->context = $context;
        $this->environment = $environment;
        $this->isDebug = $isDebug;
        $this->isTest = $isTest;
        $this->cacheDirectory = $cacheDirectory;
        $this->isImportLocalConfig = $isImportLocalConfig;
        $kernel->boot();
        register_shutdown_function([$this, 'terminateClosure']);
    }

    public function getApplication(): Application
    {
        $application = $this->kernel->getContainer()->get(Application::class);
        $application
            ->getDefinition()
            ->addOption(new InputOption('--mode', null, InputOption::VALUE_OPTIONAL, 'The run mode (main|test)'));
        return $application;
    }

    public function terminateClosure(): void
    {
        $this->kernel->terminate();
    }
}