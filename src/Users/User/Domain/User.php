<?php declare(strict_types=1);

namespace App\Users\User\Domain;

use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;

final class User
{
    /** @var UserName */
    private $userName;

    /** @var Email */
    private $email;

    /** @var Password */
    private $password;

    /** @var UserId  */
    private $userId;

    private function __construct(UserId $userId, UserName $userName, Email $email, Password $password)
    {
        $this->userId = $userId;
        $this->userName = $userName;
        $this->email = $email;
        $this->password = $password;
    }

    public static function build(UserId $userId, UserName $userName, Email $email, Password $password): self
    {
        return new static($userId, $userName, $email, $password);
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
        return $this->userName;
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
