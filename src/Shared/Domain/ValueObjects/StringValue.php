<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\DomainException;
use App\Shared\Domain\Exceptions\InvalidStringException;
use App\Shared\Domain\Specifications\StringSpecificationChain;
use ReflectionException;

abstract class StringValue
{
    private string $value;
    private ?StringSpecificationChain $specificationChain;

    /**
     * StringValue constructor.
     *
     * @throws InvalidStringException
     * @throws DomainException
     * @throws ReflectionException
     */
    final protected function __construct(string $value, ?StringSpecificationChain $specificationChain = null)
    {
        $this->value = $value;
        $this->specificationChain = $specificationChain;

        $this->guard();
    }

    /**
     * @return StringValue
     *
     * @throws InvalidStringException
     * @throws DomainException
     * @throws ReflectionException
     */
    public static function build(string $value)
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

    final public function __toString(): string
    {
        return $this->value();
    }

    /**
     * @throws InvalidStringException
     * @throws ReflectionException
     * @throws DomainException
     */
    final private function guard()
    {
        if (isset($this->specificationChain)) {
            $isValid = $this->specificationChain->evalSpecifications($this->value);

            if (!$isValid) {
                throw InvalidStringException::build();
            }
        }
    }
}
