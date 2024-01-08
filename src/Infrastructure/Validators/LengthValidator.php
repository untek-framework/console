<?php

namespace Untek\Framework\Console\Infrastructure\Validators;

use Untek\Framework\Console\Infrastructure\Interfaces\CliValidatorInterface;
use Untek\Utility\CodeGenerator\Presentation\Libs\Exception\RuntimeCommandException;

class LengthValidator implements CliValidatorInterface
{

    public static function validate($value)
    {
        if (!$length) {
            return $length;
        }

        $result = filter_var($length, \FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1],
        ]);

        if (false === $result) {
            throw new RuntimeCommandException(sprintf('Invalid length "%s".', $length));
        }

        return $result;
    }
}
