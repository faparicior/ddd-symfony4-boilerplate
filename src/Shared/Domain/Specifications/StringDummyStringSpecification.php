<?php declare(strict_types=1);

namespace App\Shared\Domain\Specifications;

class StringDummyStringSpecification implements StringSpecificationInterface
{
    public function isSatisfiedBy(string $data): bool
    {
    }
}
