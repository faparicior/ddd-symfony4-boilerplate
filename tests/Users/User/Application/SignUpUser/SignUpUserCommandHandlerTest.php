<?php declare(strict_types=1);

namespace App\Tests\Users\User\Application\SignUpUser;

use App\Users\User\Application\SignUpUser\SignUpUserCommand;
use App\Users\User\Application\SignUpUser\SignUpUserCommandHandler;
use App\Shared\Domain\Service\UniqueIdProviderStub;
use Ramsey\Uuid\UuidFactory;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class SignUpUserCommandHandlerTest extends TestCase
{
    private const USER_UUID = '73f2791e-eaa7-4f81-a8cc-7cc601cda30e';
    private const USERNAME = 'JohnDoe';
    private const EMAIL = 'test.email@gmail.com';
    private const PASSWORD = ",&+3RjwAu88(tyC'";

    /**
     * @group Users
     * @group Application
     * @throws \Exception
     */
    public function testSignUpUserCommandHandlerReturnsAValidResponse()
    {
        $command = SignUpUserCommand::build(
            self::USERNAME,
            self::EMAIL,
            self::PASSWORD
        );

        $uuidService = new UniqueIdProviderStub(new UuidFactory());
        $uuidService->setUuidToReturn(self::USER_UUID);

        $commandHandler = new SignUpUserCommandHandler($uuidService);

        $response = $commandHandler->handle($command);

        $responseExpected = [
            "id" => self::USER_UUID,
            "userName" => "JohnDoe",
            "email" => "test.email@gmail.com",
            "password" => ",&+3RjwAu88(tyC'"
        ];

        self::assertEquals($responseExpected, $response);
    }
}
