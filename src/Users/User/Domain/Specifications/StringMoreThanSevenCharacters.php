<?php

declare(strict_types=1);

namespace App\Users\User\Domain\Specifications;

use App\Shared\Domain\Specifications\StringSpecificationInterface;

class StringMoreThanSevenCharacters implements StringSpecificationInterface
{
    private const MIN_CHARACTERS = 8;
    public const SPECIFICATION_FAIL_MESSAGE = 'String less than %d characters';

    private function __construct()
    {
    }

    public static function build()
    {
        return new static();
    }

    public function isSatisfiedBy(string $data): bool
    {
        return strlen($data) >= self::MIN_CHARACTERS;
    }

    public function getFailedMessage(): string
    {
        return sprintf(self::SPECIFICATION_FAIL_MESSAGE, self::MIN_CHARACTERS);
    }
}
