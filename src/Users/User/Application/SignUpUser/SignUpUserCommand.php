<?php

declare(strict_types=1);

namespace App\Users\User\Application\SignUpUser;

final class SignUpUserCommand
{
    private string $username;
    private string $email;
    private string $password;

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

    public function username(): string
    {
        return $this->username;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
