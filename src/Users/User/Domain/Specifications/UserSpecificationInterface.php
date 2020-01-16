<?php

namespace App\Users\User\Domain\Specifications;


use App\Users\User\Domain\User;

interface UserSpecificationInterface
{
    public function isSatisfiedBy(User $user): bool;
}
