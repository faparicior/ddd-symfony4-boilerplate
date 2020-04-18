<?php declare(strict_types=1);

namespace App\Users\User\Domain\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;
use Throwable;

class UserNameInvalidByPolicyRulesException extends DomainException
{
    public const INVALID_USERNAME_MESSAGE = "Username is not valid by policy rules";

    public static function build(string $message = self::INVALID_USERNAME_MESSAGE, int $code = 0, Throwable $previous = null): UserNameInvalidByPolicyRulesException
    {
        return new static($message, $code, $previous);
    }
}
