<?php

declare(strict_types=1);

namespace App\Users\User\Domain;

use App\Shared\Domain\Exceptions\DomainException;
use App\Users\User\Domain\Exceptions\UserInvalidException;
use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use ReflectionException;

final class User
{
    private UserId $userId;
    private UserName $username;
    private Email $email;
    private Password $password;

    private function __construct(UserId $userId, UserName $userName, Email $email, Password $password)
    {
        $this->userId = $userId;
        $this->username = $userName;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return static
     *
     * @throws DomainException
     * @throws ReflectionException
     * @throws UserInvalidException
     */
    public static function build(UserId $userId, UserName $userName, Email $email, Password $password, UserSpecificationChain $specificationChain): self
    {
        $user = new static($userId, $userName, $email, $password);

        self::guard($specificationChain, $user);

        return $user;
    }

    /**
     * @param $user
     *
     * @throws DomainException
     * @throws UserInvalidException;
     * @throws ReflectionException
     */
    private static function guard(UserSpecificationChain $specificationChain, User $user): void
    {
        if (isset($specificationChain)) {
            $isValid = $specificationChain->evalSpecifications($user);

            if (!$isValid) {
                $specificationsFailed = $specificationChain->getFailedResults();
                throw UserInvalidException::build(implode(', ', $specificationsFailed));
            }
        }
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function username(): UserName
    {
        return $this->username;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function password(): Password
    {
        return $this->password;
    }
}
