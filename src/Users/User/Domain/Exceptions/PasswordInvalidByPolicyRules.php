<?php declare(strict_types=1);

namespace App\Users\User\Domain\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;
use Throwable;

class PasswordInvalidByPolicyRules extends DomainException
{
    public const INVALID_PASSWORD_MESSAGE = "Password invalid by policy rules";

    public static function build(string $message = self::INVALID_PASSWORD_MESSAGE, int $code = 0, Throwable $previous = null): DomainException
    {
        return new static($message, $code, $previous);
    }
}
