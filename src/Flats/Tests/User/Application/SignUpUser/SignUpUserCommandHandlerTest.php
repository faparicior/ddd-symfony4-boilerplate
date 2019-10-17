<?php declare(strict_types=1);

namespace App\Flats\Tests\User\Application\SignUpUser;

use App\Flats\User\Application\SignUpUser\SignUpUserCommand;
use App\Flats\User\Application\SignUpUser\SignUpUserCommandHandler;
use App\Shared\Domain\Service\UniqueUuidProviderService;
use Ramsey\Uuid\UuidFactory;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class SignUpUserCommandHandlerTest extends TestCase
{
    private const USERNAME = 'JohnDoe';
    private const EMAIL = 'test.email@gmail.com';
    private const PASSWORD = 'userpass';

    /**
     * @group Flats
     * @group Application
     */
    public function testSignUpUserCommandHandlerReturnsAValidResponse()
    {
        $command = SignUpUserCommand::build(
            self::USERNAME,
            self::EMAIL,
            self::PASSWORD
        );

        $commandHandler = new SignUpUserCommandHandler(new UniqueUuidProviderService(new UuidFactory()));

        $response = $commandHandler->handle($command);

        $responseExpected = [
            "id" => "73f2791e-eaa7-4f81-a8cc-7cc601cda30e",
            "userName" => "JohnDoe",
            "email" => "test.email@gmail.com",
            "password" => ",&+3RjwAu88(tyC'"
        ];

        self::assertEquals($responseExpected, $response);
    }
}
