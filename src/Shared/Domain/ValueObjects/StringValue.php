<?php declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

use App\Shared\Domain\Specifications\SpecificationChain;

abstract class StringValue
{
    /** @var string */
    private $value;

    /** @var SpecificationChain|null */
    private $specificationChain;

    final protected function __construct(string $value, ?SpecificationChain $specificationChain)
    {
        $this->value = $value;
        $this->specificationChain = $specificationChain;
    }

    public static function build(string $value, ?SpecificationChain $specificationChain = null)
    {
        return new static($value, $specificationChain);
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
