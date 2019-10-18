<?php declare(strict_types=1);

namespace App\Flats\User\Application\Service;

use App\Flats\User\Domain\User;
use App\Flats\User\Domain\ValueObject\Email;
use App\Flats\User\Domain\ValueObject\Password;
use App\Flats\User\Domain\ValueObject\UserId;
use App\Flats\User\Domain\ValueObject\UserName;

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
