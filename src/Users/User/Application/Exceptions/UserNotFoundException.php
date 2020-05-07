<?php declare(strict_types=1);

namespace App\Users\User\Application\Exceptions;

use App\Shared\Application\Exceptions\ApplicationException;

use \Throwable;

class UserNotFoundException extends ApplicationException
{
    public const INVALID_USER_MESSAGE = "User not found";

    public static function build(string $message = self::INVALID_USER_MESSAGE, int $code = 0, Throwable $previous = null): UserNotFoundException
    {
        return new static($message, $code, $previous);
    }
}
