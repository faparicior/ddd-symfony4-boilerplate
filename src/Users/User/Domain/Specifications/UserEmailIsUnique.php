<?php declare(strict_types=1);

namespace App\Users\User\Domain\Specifications;

use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;

class UserEmailIsUnique implements UserSpecificationInterface
{
    public const SPECIFICATION_FAIL_MESSAGE = 'User email is in use';

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
        $user = $this->userRepository->findByEmail($userToFind->email());

        return is_null($user);
    }

    public function getFailedMessage(): string
    {
        return self::SPECIFICATION_FAIL_MESSAGE;
    }
}
