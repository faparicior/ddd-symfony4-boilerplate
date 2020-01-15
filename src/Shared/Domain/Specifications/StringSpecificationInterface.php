<?php

namespace App\Shared\Domain\Specifications;


interface StringSpecificationInterface
{
    public function isSatisfiedBy(string $data);
}
