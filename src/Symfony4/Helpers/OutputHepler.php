<?php

namespace Untek\Framework\Console\Symfony4\Helpers;

use Symfony\Component\Console\Output\OutputInterface;
use Untek\Core\Code\Helpers\DeprecateHelper;

DeprecateHelper::hardThrow();

class OutputHepler
{

    public static function writeList(OutputInterface $output, array $array)
    {
        foreach ($array as $item) {
            $output->writeln(' ' . $item);
        }
    }

}