<?php

declare(strict_types=1);

namespace App\Users\User\Application\Specifications;

use App\Shared\Domain\Specifications\SpecificationChain;
use App\Users\User\Domain\User;
use ReflectionException;

final class CreateUserSpecificationChain extends SpecificationChain
{
    final private function __construct(UserSpecificationInterface ...$specifications)
    {
        $this->specifications = $specifications;
    }

    final public static function build(UserSpecificationInterface ...$specifications)
    {
        return new static(...$specifications);
    }

    /**
     * @throws ReflectionException
     */
    final public function evalSpecifications(User $user): bool
    {
        $result = $this->returnFalseIfNoSpecifications();

        foreach ($this->specifications as $specification) {
            $isSatisfied = $specification->isSatisfiedBy($user);
            $this->processSpecificationResult($isSatisfied, $specification);
            $result = $this->updateResult($result, $isSatisfied);
        }

        return $result;
    }
}
