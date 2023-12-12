<?php

namespace Untek\Framework\Console\Domain\Interfaces;

use Untek\Framework\Console\Domain\Base\BaseShellNew;

interface ShellInterface
{

    public function runCmd(string $cmd): string;
}
