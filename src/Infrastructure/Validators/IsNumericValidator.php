<?php

namespace Untek\Framework\Console\Infrastructure\Validators;

use Untek\Framework\Console\Infrastructure\Interfaces\CliValidatorInterface;
use Untek\Utility\CodeGenerator\Presentation\Libs\Exception\RuntimeCommandException;

class IsNumericValidator implements CliValidatorInterface
{
    
    public static function validate($value)
    {
        if (!is_numeric($value)) {
            throw new RuntimeCommandException('This value is not english.');
        }
        return $value;
    }
}
