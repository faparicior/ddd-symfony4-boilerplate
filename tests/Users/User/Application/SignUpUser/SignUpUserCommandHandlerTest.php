<?php declare(strict_types=1);

namespace App\Tests\Users\User\Application\SignUpUser;

use App\Shared\Domain\Service\UniqueIdProviderInterface;
use App\Users\User\Application\SignUpUser\SignUpUserCommand;
use App\Users\User\Application\SignUpUser\SignUpUserCommandHandler;
use App\Shared\Domain\Service\UniqueIdProviderStub;
use App\Users\User\Domain\UserRepositoryInterface;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;
use Ramsey\Uuid\UuidFactory;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class SignUpUserCommandHandlerTest extends TestCase
{
    private const USER_UUID = '73f2791e-eaa7-4f81-a8cc-7cc601cda30e';
    private const USERNAME = 'JohnDoe';
    private const EMAIL = 'test.email@gmail.com';
    private const PASSWORD = ",&+3RjwAu88(tyC'";

    /** @var UniqueIdProviderInterface */
    private $uuidService;

    /** @var UserRepositoryInterface */
    private $userRepository;

    public function setUp()
    {
        parent::setUp();

        $this->uuidService = new UniqueIdProviderStub(new UuidFactory());
        $this->uuidService->setUuidToReturn(self::USER_UUID);

        $this->userRepository = new InMemoryUserRepository();
    }

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

        $response = $this->handleCommand($command);

        $responseExpected = [
            "id" => self::USER_UUID,
            "userName" => "JohnDoe",
            "email" => "test.email@gmail.com",
            "password" => ",&+3RjwAu88(tyC'"
        ];

        self::assertEquals($responseExpected, $response);
    }

    /**
     * @group Users
     * @group Application
     * @throws \Exception
     */
    public function testSignUpUserCommandHandlerStoreAnUser()
    {
        $command = SignUpUserCommand::build(
            self::USERNAME,
            self::EMAIL,
            self::PASSWORD
        );

        $response = $this->handleCommand($command);
    }

    /**
     * @param $command
     * @return array
     * @throws \Exception
     */
    private function handleCommand($command)
    {
        $commandHandler = new SignUpUserCommandHandler($this->uuidService, $this->userRepository);

        return $commandHandler->handle($command);
    }
}
