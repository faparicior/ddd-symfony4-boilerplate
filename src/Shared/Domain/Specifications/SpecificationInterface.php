<?php

namespace App\Shared\Domain\Specifications;


interface SpecificationInterface
{
    public function getFailedMessage(): string;
}
