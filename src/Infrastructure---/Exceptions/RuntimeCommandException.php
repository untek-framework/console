<?php

namespace Untek\Framework\Console\Infrastructure\Exceptions;

use Symfony\Component\Console\Exception\ExceptionInterface;

final class RuntimeCommandException extends \RuntimeException implements ExceptionInterface
{
}
