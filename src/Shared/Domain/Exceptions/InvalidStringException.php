<?php

namespace App\Shared\Domain\Exceptions;

use Throwable;

final class InvalidStringException extends DomainException
{
    public const INVALID_STRING_MESSAGE = 'Invalid string due to policy rules';

    public static function build(string $message = self::INVALID_STRING_MESSAGE, int $code = 0, Throwable $previous = null): InvalidStringException
    {
        return new static($message, $code, $previous);
    }
}
