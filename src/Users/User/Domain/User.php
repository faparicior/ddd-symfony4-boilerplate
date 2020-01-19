<?php declare(strict_types=1);

namespace App\Users\User\Domain;

use App\Users\User\Domain\Exceptions\UserExists;
use App\Users\User\Domain\Specifications\UserEmailIsUnique;
use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;

final class User
{
    /** @var UserName */
    private $username;

    /** @var Email */
    private $email;

    /** @var Password */
    private $password;

    /** @var UserId  */
    private $userId;

    private function __construct(UserId $userId, UserName $userName, Email $email, Password $password)
    {
        $this->userId = $userId;
        $this->username = $userName;
        $this->email = $email;
        $this->password = $password;
    }

    public static function build(UserId $userId, UserName $userName, Email $email, Password $password, UserSpecificationChain $specificationChain): self
    {
        $user = new static($userId, $userName, $email, $password);

        self::guard($specificationChain, $user);

        return $user;
    }

    /**
     * @param UserSpecificationChain $specificationChain
     * @param $user
     * @throws \App\Shared\Domain\Exceptions\DomainException
     * @throws \App\Users\User\Domain\Exceptions\UserExists;
     */
    private static function guard(UserSpecificationChain $specificationChain, $user): void
    {
        if (isset($specificationChain)) {
            $isValid = $specificationChain->evalSpecifications($user);

            if (!$isValid) {
                $specificationsFailed = $specificationChain->getFailedResults();
                throw UserExists::build(implode(', ',$specificationsFailed));
            }
        }
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return UserName
     */
    public function username(): UserName
    {
        return $this->username;
    }

    /**
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * @return Password
     */
    public function password(): Password
    {
        return $this->password;
    }
}
