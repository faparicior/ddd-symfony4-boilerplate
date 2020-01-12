<?php declare(strict_types=1);

namespace App\Shared\Domain\Exceptions;

use Throwable;

final class InvalidEmailException extends DomainException
{
    public const INVALID_EMAIL_MESSAGE = "Invalid Email format";

    public static function build(string $message = self::INVALID_EMAIL_MESSAGE, int $code = 0, Throwable $previous = null): DomainException
    {
        return new static($message, $code, $previous);
    }
}
