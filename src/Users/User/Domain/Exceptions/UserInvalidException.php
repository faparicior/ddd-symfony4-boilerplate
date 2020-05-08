<?php

declare(strict_types=1);

namespace App\Users\User\Domain\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;
use Throwable;

class UserInvalidException extends DomainException
{
    public const INVALID_USER_MESSAGE = 'User is not valid due to policy chain';

    public static function build(string $message = self::INVALID_USER_MESSAGE, int $code = 0, Throwable $previous = null): UserInvalidException
    {
        return new static($message, $code, $previous);
    }
}
