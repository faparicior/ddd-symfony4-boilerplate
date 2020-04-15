<?php

namespace App\Shared\Domain\Specifications;

interface SpecificationChainInterface
{
    public function getResults(): array;

    public function getFailedResults(): array;
}
