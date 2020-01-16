<?php declare(strict_types=1);

namespace App\Tests\Users\User\Application\SignUpUser;

use App\Shared\Infrastructure\Services\UniqueIdProviderInterface;
use App\Users\User\Application\SignUpUser\SignUpUserCommand;
use App\Users\User\Application\SignUpUser\SignUpUserCommandHandler;
use App\Shared\Infrastructure\Services\UniqueIdProviderStub;
use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\Specifications\UserSpecificationInterface;
use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;
use Ramsey\Uuid\UuidFactory;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserSpecificationStub implements UserSpecificationInterface
{
    public function isSatisfiedBy(User $user): bool
    {
        return true;
    }
}

class SignUpUserCommandHandlerTest extends TestCase
{
    private const USER_UUID = UniqueIdProviderStub::USER_UUID;
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
     * @group UnitTests
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
            "userName" => self::USERNAME,
            "email" => self::EMAIL,
            "password" => self::PASSWORD
        ];

        self::assertEquals($responseExpected, $response);
    }

    /**
     * @group UnitTests
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

        $user = $this->userRepository->findById(UserId::fromString($response['id']));

        self::assertEquals(self::USER_UUID, $user->userId()->value());
    }

    /**
     * @param $command
     * @return array
     * @throws \Exception
     */
    private function handleCommand($command)
    {
        $commandHandler = new SignUpUserCommandHandler($this->uuidService, $this->userRepository, UserSpecificationChain::build(...[new UserSpecificationStub()]));

        return $commandHandler->handle($command);
    }
}
