<?php declare(strict_types=1);

namespace App\Users\User\Domain\Specifications;

use App\Shared\Domain\Specifications\SpecificationInterface;
use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;

class UserNameIsUnique implements SpecificationInterface
{
    /** @var UserRepositoryInterface */
    private $userRepository;

    private function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public static function build(UserRepositoryInterface $userRepository)
    {
        return new static($userRepository);
    }

    public function isSatisfiedBy(User $userToFind): bool
    {
        $user = $this->userRepository->findByName($userToFind->username());
        var_dump($user);

        return is_null($user);
    }
}
