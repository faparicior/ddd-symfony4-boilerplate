<?php declare(strict_types=1);

namespace App\Shared\Ui\Http\Api\Rest\Exceptions;

use Throwable;

class InvalidDataException extends UiException
{
    public const INVALID_EMAIL_MESSAGE = "Empty data or bad json received";

    public static function build(string $message = self::INVALID_EMAIL_MESSAGE, int $code = 0, Throwable $previous = null): InvalidDataException
    {
        return new static($message, $code, $previous);
    }
}
