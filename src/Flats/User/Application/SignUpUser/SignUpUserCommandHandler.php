<?php declare(strict_types=1);

namespace App\Flats\User\Application\SignUpUser;

final class SignUpUserCommandHandler
{
    public function handle(SignUpUserCommand $command)
    {
        return [
            "id" => "73f2791e-eaa7-4f81-a8cc-7cc601cda30e",
            "userName" => "JohnDoe",
            "email" => "test.email@gmail.com",
            "password" => ",&+3RjwAu88(tyC'"
        ];
    }
}
