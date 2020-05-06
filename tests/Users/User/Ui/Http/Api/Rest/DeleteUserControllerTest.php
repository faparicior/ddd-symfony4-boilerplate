<?php declare(strict_types=1);

namespace App\Tests\Users\User\Ui\Http\Api\Rest;

use App\Shared\Domain\Exceptions\InvalidEmailException;
use App\Shared\Infrastructure\Services\UniqueIdProviderStub;
use App\Tests\Uses\User\Domain\Specifications\UserSpecificationOkStub;
use App\Users\User\Application\DeleteUser\DeleteUserCommand;
use App\Users\User\Application\DeleteUser\DeleteUserCommandHandler;
use App\Users\User\Application\SignUpUser\SignUpUserCommand;
use App\Users\User\Application\SignUpUser\SignUpUserCommandHandler;
use App\Users\User\Domain\Specifications\UserEmailIsUnique;
use App\Users\User\Domain\Specifications\UserNameIsUnique;
use App\Users\User\Domain\Specifications\UserSpecificationChain;
use App\Users\User\Domain\User;
use App\Users\User\Domain\ValueObjects\Email;
use App\Users\User\Domain\ValueObjects\Password;
use App\Users\User\Domain\ValueObjects\UserId;
use App\Users\User\Domain\ValueObjects\UserName;
use App\Users\User\Infrastructure\Persistence\InMemoryUserRepository;
use App\Users\User\Ui\Http\Api\Rest\DeleteUserController;
use App\Users\User\Ui\Http\Api\Rest\SignUpUserController;
use League\Tactician\CommandBus;
use League\Tactician\Setup\QuickStart;
use Monolog\Handler\TestHandler;
use Monolog\Logger;
use Ramsey\Uuid\UuidFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteUserControllerTest extends TestCase
{
    private const USERNAME = 'JohnDoe';
    private const EMAIL = 'test.email@gmail.com';
    private const INEXISTENT_EMAIL = 'non-email@gmail.com';
    private const PASSWORD = ",&+3RjwAu88(tyC'";

    private CommandBus $bus;
    private Logger $log;

    public function setUp()
    {
        parent::setUp();

        $userRepository = new InMemoryUserRepository();

        $userRepository->create(User::build(
            UserId::build(),
            UserName::build(self::USERNAME),
            Email::build(self::EMAIL),
            Password::build(self::PASSWORD),
            UserSpecificationChain::build(new UserSpecificationOkStub())
        ));

        $deleteUserCommandHandler = new DeleteUserCommandHandler($userRepository);

        $this->bus = QuickStart::create([DeleteUserCommand::class => $deleteUserCommandHandler]);

        $this->log = new Logger('testLog');
        $logHandler = new TestHandler();
        $this->log->pushHandler($logHandler);
    }

    /**
     * @group UnitTests
     * @group Users
     * @group Ui
     */
    public function testUserCanBeDeleted()
    {
        $data = json_encode([
            "email" => self::EMAIL
        ]);

        $request = Request::create('/users', 'DELETE', [], [], [], [], $data);

        $controller = new DeleteUserController($this->bus, $this->log);

        $response = $controller->execute($request);

        self::assertJsonStringEqualsJsonString('{}', $response->getContent());
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testDeleteUserReturnsBadRequestWithInexistentUser()
    {
        $data = json_encode([
            "email" => self::INEXISTENT_EMAIL
        ]);

        $request = Request::create('/users', 'DELETE', [], [], [], [], $data);

        $controller = new DeleteUserController($this->bus, $this->log);

        $response = $controller->execute($request);

        self::assertEquals('"User not found"', $response->getContent());
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
