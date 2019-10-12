<?php declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class StringValue
{
    /** @var string */
    private $value;

    final private function __construct(string $value)
    {
        $this->value = $value;
    }

    final public static function build(string $value)
    {
        return new static($value);
    }

    final public function value(): string
    {
        return $this->value;
    }

    final public function equals(self $valueObject): bool
    {
        return $this->value === $valueObject->value();
    }
}
