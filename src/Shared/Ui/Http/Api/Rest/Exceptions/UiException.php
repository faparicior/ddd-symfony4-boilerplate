<?php declare(strict_types=1);

namespace App\Shared\Ui\Http\Api\Rest\Exceptions;

use Exception;
use Throwable;

abstract class UiException extends Exception
{
    protected function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function build(string $message = "", int $code = 0, Throwable $previous = null): self
    {
        return new static($message, $code, $previous);
    }
}
