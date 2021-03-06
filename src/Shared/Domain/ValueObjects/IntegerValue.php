<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

abstract class IntegerValue
{
    private int $value;

    final private function __construct(int $value)
    {
        $this->value = $value;
    }

    final public static function build(int $value)
    {
        return new static($value);
    }

    final public function value(): int
    {
        return $this->value;
    }

    final public function equals(self $valueObject): bool
    {
        return $this->value === $valueObject->value();
    }
}
