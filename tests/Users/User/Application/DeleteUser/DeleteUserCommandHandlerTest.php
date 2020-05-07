<?php declare(strict_types=1);

namespace App\Tests\Users\User\Application\DeleteUser;

use App\Tests\Uses\User\Domain\Specifications\UserSpecificationOkStub;
use App\Users\User\Application\DeleteUser\DeleteUserCommand;
use App\Users\User\Application\DeleteUser\DeleteUserCommandHandler;
use App\Users\User\Application\Exceptions\UserNotFoundException;
use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\User;
use App\Users\User\Domain\UserRepositoryInterface;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;
use Exception;
use PHPUnit\Framework\TestCase;

class DeleteUserCommandHandlerTest extends TestCase
{
    private const USERNAME = 'JohnDoe';
    private const EMAIL = 'test.email@gmail.com';
    private const NON_EXISTENT_EMAIL = 'no-email@gmail.com';
    private const PASSWORD = ",&+3RjwAu88(tyC'";
    private UserRepositoryInterface $userRepository;

    public function setUp()
    {
        parent::setUp();

        $this->userRepository = new InMemoryUserRepository();

        $this->userRepository->create(User::build(
            UserId::build(),
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD),
            UserSpecificationChain::build(new UserSpecificationOkStub())
        ));
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Application
     * @throws Exception
     */
    public function testDeleteUserCommandHandlerReturnsAValidResponse()
    {
        $command = DeleteUserCommand::build(self::EMAIL);

        $response = $this->handleCommand($command);

        self::assertTrue($response);
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Application
     * @throws Exception
     */
    public function testDeleteUserCommandHandlerDeleteTheUser()
    {
        $command = DeleteUserCommand::build(self::EMAIL);

        $response = $this->handleCommand($command);

        $user = $this->userRepository->findByEmail(Email::build(self::EMAIL));

        self::assertTrue($response);
        self::assertNull($user);
    }

    public function testUserCannotBeFoundThrowsAnError()
    {
        self::expectException(UserNotFoundException::class);

        $command = DeleteUserCommand::build(self::NON_EXISTENT_EMAIL);
        $this->handleCommand($command);

    }

    /**
     * @param $command
     * @return bool
     * @throws Exception|UserNotFoundException
     */
    private function handleCommand($command)
    {
        $commandHandler = new DeleteUserCommandHandler($this->userRepository);

        return $commandHandler->handle($command);
    }
}
