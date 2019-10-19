<?php declare(strict_types=1);

namespace App\Users\User\Application\Service;

use App\Users\User\Domain\User;
use App\Users\User\Domain\ValueObject\Email;
use App\Users\User\Domain\ValueObject\Password;
use App\Users\User\Domain\ValueObject\UserId;
use App\Users\User\Domain\ValueObject\UserName;

final class UserBuilder
{
    public function __construct()
    {

    }

    public static function build(UserId $userId, UserName $userName, Email $email, Password $password): User
    {
        return User::build($userId, $userName, $email, $password);
    }
}
