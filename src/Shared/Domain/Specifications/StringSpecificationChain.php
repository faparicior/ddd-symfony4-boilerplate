<?php

declare(strict_types=1);

namespace App\Shared\Domain\Specifications;

use ReflectionException;

class StringSpecificationChain extends SpecificationChain
{
    final private function __construct(StringSpecificationInterface ...$specifications)
    {
        $this->specifications = $specifications;
    }

    final public static function build(StringSpecificationInterface ...$specifications)
    {
        return new static(...$specifications);
    }

    /**
     * @throws ReflectionException
     */
    final public function evalSpecifications(string $data): bool
    {
        $result = $this->returnFalseIfNoSpecifications();

        foreach ($this->specifications as $specification) {
            $isSatisfied = $specification->isSatisfiedBy($data);
            $this->processSpecificationResult($isSatisfied, $specification);
            $result = $this->updateResult($result, $isSatisfied);
        }

        return $result;
    }
}
