<?php declare(strict_types=1);

namespace App\Users\User\Domain\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;
use Throwable;

class PasswordInvalidByPolicyRulesException extends DomainException
{
    public const INVALID_PASS_MESSAGE = "Password invalid by policy rules";

    public static function build(string $message = self::INVALID_PASS_MESSAGE, int $code = 0, Throwable $previous = null): PasswordInvalidByPolicyRulesException
    {
        return new static($message, $code, $previous);
    }
}
