<?php declare(strict_types=1);

namespace App\Users\User\Domain\Specifications;

use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;

class UserIdIsUnique implements UserSpecificationInterface
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
        $user = $this->userRepository->findById($userToFind->userId());

        return is_null($user);
    }
}
