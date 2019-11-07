<?php

namespace App\Shared\Domain\Specifications;

use App\Users\User\Domain\Specifications\StringMoreThanSevenCharacters;

interface StringSpecificationInterface
{

    public function isSatisfiedBy(string $data);
}
