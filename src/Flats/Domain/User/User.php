<?php declare(strict_types=1);

namespace App\Flats\Domain\User;

use App\Flats\Domain\User\ValueObject\Email;
use App\Flats\Domain\User\ValueObject\Password;
use App\Flats\Domain\User\ValueObject\UserName;

final class User
{
    /** @var UserName */
    private $userName;

    /** @var Email */
    private $email;

    /** @var Password */
    private $password;

    private function __construct(UserName $userName, Email $email, Password $password)
    {
        $this->userName = $userName;
        $this->email = $email;
        $this->password = $password;
    }

    public static function build(UserName $userName, Email $email, Password $password): self
    {
        return new static($userName, $email, $password);
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
