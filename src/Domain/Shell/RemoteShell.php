<?php

namespace Untek\Framework\Console\Domain\Shell;

use Untek\Framework\Console\Domain\Interfaces\ShellInterface;

class RemoteShell extends LocalShell implements ShellInterface
{

    private ?string $sudoPassword = null;
    private SshConfig $sshConfig;

    public function __construct(string $path = null)
    {
        $this->path = $path;
    }

    /**
     * @return SshConfig
     */
    public function getSshConfig(): SshConfig
    {
        return $this->sshConfig;
    }

    /**
     * @param SshConfig $sshConfig
     */
    public function setSshConfig(SshConfig $sshConfig): void
    {
        $this->sshConfig = $sshConfig;
    }

    public function setSudoPassword(string $sudoPassword): void
    {
        $this->sudoPassword = $sudoPassword;
    }

    public function runCmd(string $cmd, string $path = null): string
    {
//        $shell = new Shell($this->path);
        $cmd = $this->prepareCmd($cmd, $path);
        $ssh = $this->prepareSsh();
        $escapedCmd = str_replace('"', '\"', $cmd);
        return $this->runCommandRaw("$ssh \"$escapedCmd\"");
//        return parent::runCmd($cmd);
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    private function prepareSsh(): string
    {
        $config = $this->sshConfig;
        $command = '';
        if ($config->getPasswordFile()) {
            $command .= "export SSH_ASKPASS=\"{$config->getPasswordFile()}\" && setsid ";
        } elseif ($config->getPassword()) {
            $command .= "echo \"echo shee8Eem\" > /tmp/1 && chmod 777 /tmp/1 && ";
            $command .= "export SSH_ASKPASS=\"/tmp/1\" && setsid ";
        }
        $command .= "ssh {$config->getUser()}@{$config->getHost()} -p {$config->getPort()}";
        return $command;
    }
}
