<?php

namespace App\Shared\Domain\Specifications;


interface StringSpecificationInterface extends SpecificationInterface
{
    public function isSatisfiedBy(string $data): bool;
}
