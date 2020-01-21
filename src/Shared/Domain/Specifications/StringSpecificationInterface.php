<?php

namespace App\Shared\Domain\Specifications;


interface StringSpecificationInterface
{
    public function isSatisfiedBy(string $data): bool;

    public function getFailedMessage(): string;
}
