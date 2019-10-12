<?php declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use Throwable;

class InvalidEmailException extends \Exception
{
    private function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function build(): self
    {
        return new static();
    }
}
