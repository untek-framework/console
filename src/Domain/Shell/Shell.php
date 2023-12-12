<?php

namespace Untek\Framework\Console\Domain\Shell;

use Untek\Framework\Console\Domain\Base\BaseShellNew;
use Untek\Framework\Console\Domain\Interfaces\ShellInterface;

class Shell extends BaseShellNew implements ShellInterface
{

    public function runCmd(string $cmd): string
    {
        $command = '';
        if ($this->path) {
            $command .= "cd \"{$this->path}\" && ";
        }
        $command .= $cmd;
        return $this->runCommand($command);
    }
}
