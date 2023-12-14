<?php

namespace Untek\Framework\Console\Domain\Shell;

use Untek\Framework\Console\Domain\Interfaces\ShellInterface;

class RemoteShell extends LocalShell implements ShellInterface
{

    private ?string $sudoPassword = null;
    private string $remoteHost;
    private string $remoteUser;
    private int $remotePort = 22;
    private string $remotePassword;

    protected $path = null;

    public function __construct(string $path = null)
    {
        $this->path = $path;
    }

    /**
     * @var string
     * Файл должен содержать примерно следующее: echo Qqqwww111
     */
    private string $remotePasswordFile;

    public function setSudoPassword(string $sudoPassword): void
    {
        $this->sudoPassword = $sudoPassword;
    }

    /**
     * @param string $remoteHost
     */
    public function setRemoteHost(string $remoteHost): void
    {
        $this->remoteHost = $remoteHost;
    }

    /**
     * @param string $remoteUser
     */
    public function setRemoteUser(string $remoteUser): void
    {
        $this->remoteUser = $remoteUser;
    }

    /**
     * @param int $remotePort
     */
    public function setRemotePort(int $remotePort): void
    {
        $this->remotePort = $remotePort;
    }

    /**
     * @param string $remotePassword
     */
    public function setRemotePassword(string $remotePassword): void
    {
        $this->remotePassword = $remotePassword;
    }

    /**
     * @param string $remotePasswordFile
     */
    public function setRemotePasswordFile(string $remotePasswordFile): void
    {
        $this->remotePasswordFile = $remotePasswordFile;
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
        $command = '';
        if (isset($this->remotePasswordFile)) {
            $command .= "export SSH_ASKPASS=\"{$this->remotePasswordFile}\" && setsid ";
        } elseif (isset($this->remotePassword)) {
            $command .= "echo \"echo shee8Eem\" > /tmp/1 && chmod 777 /tmp/1 && ";
            $command .= "export SSH_ASKPASS=\"/tmp/1\" && setsid ";
        }
        $command .= "ssh {$this->remoteUser}@{$this->remoteHost} -p {$this->remotePort}";
        return $command;
    }
}
