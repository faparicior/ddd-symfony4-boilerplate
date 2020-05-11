<?php

declare(strict_types=1);

namespace App\Users\User\Application\Service;

use App\Shared\Domain\Exceptions\DomainException;
use App\Users\User\Domain\Exceptions\UserInvalidException;
use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use ReflectionException;

final class UserBuilder
{
    private UserRepositoryInterface $userRepository;
    private UserSpecificationChain $userSpecifications;

    public function __construct(UserRepositoryInterface $userRepository, UserSpecificationChain $userSpecifications)
    {
        $this->userRepository = $userRepository;
        $this->userSpecifications = $userSpecifications;
    }

    /**
     * @throws DomainException
     * @throws UserInvalidException
     * @throws ReflectionException
     */
    public function create(UserId $userId, UserName $userName, Email $email, Password $password): User
    {
        $user = User::build($userId, $userName, $email, $password, $this->userSpecifications);
        $this->userRepository->create($user);

        return $user;
    }
}
