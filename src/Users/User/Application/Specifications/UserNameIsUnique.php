<?php

declare(strict_types=1);

namespace App\Users\User\Application\Specifications;

use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;

class UserNameIsUnique implements UserSpecificationInterface
{
    public const SPECIFICATION_FAIL_MESSAGE = 'Username is in use';

    private UserRepositoryInterface $userRepository;

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

        return is_null($user);
    }

    public function getFailedMessage(): string
    {
        return self::SPECIFICATION_FAIL_MESSAGE;
    }
}
