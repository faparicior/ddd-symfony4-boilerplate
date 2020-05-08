<?php

declare(strict_types=1);

namespace App\Users\User\Ui\Http\Api\Rest;

use App\Shared\Ui\Http\Api\Rest\AppController;
use App\Users\User\Application\SignUpUser\SignUpUserCommand;

class SignUpUserController extends AppController
{
    public function handleRequest($data): array
    {
        $signUpUser = SignUpUserCommand::build(
            $data['userName'],
            $data['email'],
            $data['password']
        );

        return $this->bus->handle($signUpUser);
    }
}
