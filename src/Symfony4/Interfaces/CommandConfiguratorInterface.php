<?php

namespace Untek\Framework\Console\Symfony4\Interfaces;

use Symfony\Component\Console\Command\Command;
use Untek\Core\Code\Helpers\DeprecateHelper;

DeprecateHelper::hardThrow();
interface CommandConfiguratorInterface
{

//    public function registerFromNamespaceList(array $namespaceList): void;

    public function registerCommandInstance(Command $commandInstance): void;

    public function registerCommandClass(string $commandClassName): void;

}
