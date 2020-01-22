<?php

namespace App\Users\User\Domain\Specifications;

use App\Shared\Domain\Specifications\SpecificationInterface;
use App\Users\User\Domain\User;

interface UserSpecificationInterface extends SpecificationInterface
{
    public function isSatisfiedBy(User $user): bool;
}
