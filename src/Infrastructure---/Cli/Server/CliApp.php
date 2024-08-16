<?php

namespace Untek\Framework\Console\Infrastructure\Cli\Server;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Untek\Core\App\Bootstrap\ConfigDirectory;
use Untek\Core\App\Bootstrap\DotEnvLoader;
use Untek\Core\App\Bootstrap\Kernel;

class CliApp
{

    public static function run(string $projectDirectory, string $configDir, string $envDirectory): Application
    {
        $input = new ArgvInput();
        $mode = $input->getParameterOption('--mode', 'main');
        $isTest = $mode == 'test';

        $context = 'console';
        (new DotEnvLoader($projectDirectory, $context, $isTest, $envDirectory))->load();

        $env = getenv('APP_ENV');
        $isDebug = getenv('APP_DEBUG');
        $cacheDirectory = getenv('CACHE_DIRECTORY');
        $isImportLocalConfig = getenv('IMPORT_LOCAL_CONFIG');

        $configDirectory = new ConfigDirectory($configDir);
        $kernel = new Kernel(
            $configDirectory,
            $context,
            $env,
            $cacheDirectory,
            $isImportLocalConfig,
            $isDebug,
            $isTest
        );

        $cliKernel = new CliKernel(
            $kernel,
            $context,
            $env,
            $cacheDirectory,
            $isImportLocalConfig,
            $isDebug,
            $isTest
        );

        $application = $cliKernel->getApplication();
        $application->run($input);
    }
}