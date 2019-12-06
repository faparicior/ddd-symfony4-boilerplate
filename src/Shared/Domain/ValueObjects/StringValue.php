<?php declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\InvalidStringException;
use App\Shared\Domain\Specifications\StringSpecificationChain;

abstract class StringValue
{
    /** @var string */
    private $value;

    /** @var StringSpecificationChain|null */
    private $specificationChain;

    /**
     * StringValue constructor.
     * @param string $value
     * @param StringSpecificationChain|null $specificationChain
     * @throws InvalidStringException
     */
    final protected function __construct(string $value, ?StringSpecificationChain $specificationChain = null)
    {
        $this->value = $value;
        $this->specificationChain = $specificationChain;

        $this->guard();
    }

    /**
     * @param string $value
     * @return StringValue
     * @throws InvalidStringException
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
     */
    final private function guard()
    {
        if(isset($this->specificationChain)) {
            $isValid = $this->specificationChain->evalSpecifications($this->value);

            if(!$isValid) {
                throw InvalidStringException::build();
            }
        }
    }
}
