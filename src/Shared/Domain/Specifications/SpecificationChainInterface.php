<?php

namespace App\Shared\Domain\Specifications;

use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\User;

interface SpecificationChainInterface
{
    public function getResults(): array;

    public function getFailedResults(): array;
}
