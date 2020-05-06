<?php declare(strict_types=1);

namespace App\Users\User\Application\DeleteUser;

final class DeleteUserCommand
{
    private string $email;

    private function __construct(string $email)
    {
        $this->email = $email;
    }

    public static function build(string $email): self
    {
        return new static($email);
    }

    public function email(): string
    {
        return $this->email;
    }
}
