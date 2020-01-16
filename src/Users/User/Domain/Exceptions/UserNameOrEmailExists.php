<?php declare(strict_types=1);

namespace App\Users\User\Domain\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;

use \Throwable;

class UserNameOrEmailExists extends DomainException
{
    public const INVALID_USER_MESSAGE = "Username or email is in use";

    public static function build(string $message = self::INVALID_USER_MESSAGE, int $code = 0, Throwable $previous = null): DomainException
    {
        return new static($message, $code, $previous);
    }
}
