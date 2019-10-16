<?php declare(strict_types=1);

namespace App\Flats\User\Domain;

use App\Flats\User\Domain\ValueObject\Email;
use App\Flats\User\Domain\ValueObject\Password;
use App\Flats\User\Domain\ValueObject\UserName;

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
