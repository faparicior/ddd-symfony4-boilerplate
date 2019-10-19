<?php declare(strict_types=1);

namespace App\Users\User\Application\SignUpUser;

final class SignUpUserCommand
{
    /** @var string */
    private $username;

    /** @var string */
    private $email;

    /** @var string */
    private $password;

    private function __construct(string $username, string $email, string $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public static function build(string $username, string $email, string $password): self
    {
        return new static($username, $email, $password);
    }

    /**
     * @return string
     */
    public function username(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }
}
