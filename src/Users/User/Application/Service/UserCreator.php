<?php

declare(strict_types=1);

namespace App\Users\User\Application\Service;

use App\Users\User\Application\Exceptions\UserInvalidException;
use App\Users\User\Application\Specifications\CreateUserSpecificationChain;
use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;

final class UserCreator
{
    private UserRepositoryInterface $userRepository;
    private CreateUserSpecificationChain $specificationChain;

    public function __construct(UserRepositoryInterface $userRepository, CreateUserSpecificationChain $userSpecifications)
    {
        $this->userRepository = $userRepository;
        $this->specificationChain = $userSpecifications;
    }

    /**
     * @throws UserInvalidException
     */
    public function create(UserId $userId, UserName $userName, Email $email, Password $password): User
    {
        $user = User::build($userId, $userName, $email, $password);
        $this->guard($user);

        $this->userRepository->create($user);

        return $user;
    }

    /**
     * @throws UserInvalidException
     */
    private function guard(User $user): void
    {
        if (isset($this->specificationChain)) {
            $isValid = $this->specificationChain->evalSpecifications($user);

            if (!$isValid) {
                $specificationsFailed = $this->specificationChain->getFailedResults();
                throw UserInvalidException::build(implode(', ', $specificationsFailed));
            }
        }
    }
}
