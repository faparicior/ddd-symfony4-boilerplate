<?php declare(strict_types=1);

namespace App\Flats\User\Domain;

use App\Flats\User\Domain\ValueObject\Email;
use App\Flats\User\Domain\ValueObject\Password;
use App\Flats\User\Domain\ValueObject\UserId;
use App\Flats\User\Domain\ValueObject\UserName;

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
