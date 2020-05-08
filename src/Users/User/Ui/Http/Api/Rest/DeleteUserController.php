<?php

declare(strict_types=1);

namespace App\Users\User\Ui\Http\Api\Rest;

use App\Shared\Ui\Http\Api\Rest\AppController;
use App\Users\User\Application\DeleteUser\DeleteUserCommand;

class DeleteUserController extends AppController
{
    public function handleRequest($data): ?array
    {
        $deleteUser = DeleteUserCommand::build(
            $data['email']
        );

        $this->bus->handle($deleteUser);

        return null;
    }
}
