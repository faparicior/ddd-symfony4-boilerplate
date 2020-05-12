<?php

declare(strict_types=1);

namespace App\Tests\Users\User\Application\SignUpUser;

use App\Shared\Infrastructure\Services\UniqueIdProviderInterface;
use App\Shared\Infrastructure\Services\UniqueIdProviderStub;
use App\Users\User\Application\Service\UserCreator;
use App\Users\User\Application\SignUpUser\SignUpUserCommand;
use App\Users\User\Application\SignUpUser\SignUpUserCommandHandler;
use App\Users\User\Application\Specifications\CreateUserSpecificationChain;
use App\Users\User\Application\Specifications\UserSpecificationInterface;
use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;
use Exception;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidFactory;

class UserSpecificationStub implements UserSpecificationInterface
{
    public function isSatisfiedBy(User $user): bool
    {
        return true;
    }

    public function getFailedMessage(): string
    {
        // TODO: Implement getFailedMessage() method.
    }
}

class SignUpUserCommandHandlerTest extends TestCase
{
    private const USER_UUID = UniqueIdProviderStub::USER_UUID;
    private const USERNAME = 'JohnDoe';
    private const EMAIL = 'test.email@gmail.com';
    private const PASSWORD = ",&+3RjwAu88(tyC'";

    private UniqueIdProviderInterface $uuidService;
    private UserRepositoryInterface $userRepository;
    private UserCreator $userBuilder;

    public function setUp()
    {
        parent::setUp();

        $this->uuidService = new UniqueIdProviderStub(new UuidFactory());
        $this->uuidService->setUuidToReturn(self::USER_UUID);

        $this->userRepository = new InMemoryUserRepository();
        $this->userBuilder = new UserCreator(
            $this->userRepository,
            CreateUserSpecificationChain::build(...[new UserSpecificationStub()])
        );
    }

    /**
     * @throws Exception
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
            'id' => self::USER_UUID,
            'userName' => self::USERNAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ];

        self::assertEquals($responseExpected, $response);
    }

    /**
     * @throws Exception
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
     *
     * @return array
     *
     * @throws Exception
     */
    private function handleCommand($command)
    {
        $commandHandler = new SignUpUserCommandHandler($this->uuidService, $this->userBuilder);

        return $commandHandler->handle($command);
    }
}
