<?php

declare(strict_types=1);

namespace App\Users\User\Application\Service;

use App\Shared\Domain\Exceptions\DomainException;
use App\Users\User\Domain\Exceptions\UserInvalidException;
use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\User;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use ReflectionException;

final class UserBuilder
{
    /**
     * @throws DomainException
     * @throws UserInvalidException
     * @throws ReflectionException
     */
    public static function build(UserId $userId, UserName $userName, Email $email, Password $password, UserSpecificationChain $userSpecifications): User
    {
        return User::build($userId, $userName, $email, $password, $userSpecifications);
    }
}
