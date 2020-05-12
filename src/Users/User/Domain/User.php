<?php

declare(strict_types=1);

namespace App\Users\User\Domain;

use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;

class User
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

    public static function build(UserId $userId, UserName $userName, Email $email, Password $password): self
    {
        $user = new static($userId, $userName, $email, $password);

        return $user;
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
