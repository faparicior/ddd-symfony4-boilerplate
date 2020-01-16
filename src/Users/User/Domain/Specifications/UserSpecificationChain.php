<?php declare(strict_types=1);

namespace App\Users\User\Domain\Specifications;

use App\Users\User\Domain\User;

final class UserSpecificationChain
{
    /** @var UserSpecificationChain[] */
    private $specifications;

    final private function __construct(UserSpecificationInterface ...$specifications)
    {
        $this->specifications = $specifications;
    }

    final public static function build(UserSpecificationInterface ...$specifications)
    {
        return new static(...$specifications);
    }

    final public function evalSpecifications(User $user): bool
    {
        $result = false;

        foreach ($this->specifications as $specification)
        {
            $result = $specification->isSatisfiedBy($user);

            if (!$result)
            {
                break;
            }
        }

        return $result;
    }
}
